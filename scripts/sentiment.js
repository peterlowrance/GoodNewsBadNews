const API_KEY_WATSON = "uq66iCmak2IkCFwbsspio6-2yepKCHd0YsMxBTA1YwM3";
// new key:  IaZZG7SI1dNuGclMhd2goxmvOrAoKBBAjpWtMivHWILR


// uses Watson sentiment analysis to determine if the article is happy or sad
function sentiment(article) {

    var getBlacklist = $.get("scripts/GetBlacklist.php");
    getBlacklist.done(function(data){
        var blacklist = data.split(', ');

        let sentimentString = "";
        sentimentString += article["title"] + ". ";
        sentimentString += article["description"];
        sentimentString += article["content"];
        sentimentString = sentimentString.replace(/(\r\n|\n|\r)/gm, " ");

        if(blacklist[0] != "") {
            for (let word of blacklist) {
                if (sentimentString.includes(word)) {
                    return -1;
                }
            }
        }

        // If the happiness was set by cache, skip to partitioning
        if (article["happiness"]) {
            partitionNews(article);
            return 0;
        }
        console.log("Watson Request");

        let url = "https://gateway.watsonplatform.net/tone-analyzer/api/v3/tone?version=2017-09-21&sentences=false";

        let jqxhr = $.ajax({
            url: url + '&text=' + sentimentString,
            headers: {
                'Content-Type': 'application/json'
            },
            method: 'GET',
            dataType: 'json',
            disableSslVerification: true,
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", "Basic " + btoa('apikey' + ":" + API_KEY_WATSON));
            },
        });

        // Set the callback for if/when the AJAX request successfully returns
        jqxhr.done(function (data) {
            article["happiness"] = happyOrSad(data["document_tone"]["tones"]);
            partitionNews(article);
            //use a countdown and a timer. Possibly array of jqxhr that has a callback
        });

        // Set the callback for if/when the AJAX request fails
        jqxhr.fail(function (jqXHR) {
            // jqXHR is the failed call (so we can access status, e.g.)
            console.log("Error: " + jqXHR.status);
        });
        // Set a callback to execute regardless of success or failure result
        /*jqxhr.always(function(){
            console.log("Done sentiment with AJAX request");
        });*/

        return 0;
    });
    return -1;
}

// Use the sentiment of each article to partition it into happy and sad articles
function partitionNews(article) {
    // Set the cookie
    $.cookie(article["title"].substring(0, 15), article["happiness"]);
    var s = article["happiness"];
    if (s > 0) {
        if (isHappy) {
            displayArticle(article);
        }
        happy.push(article);
    } else if (s < 0) {
        if (!isHappy) {
            displayArticle(article);
        }
        sad.push(article);
    }
}


// returns a positive number for happy articles and a negative number for sad articles
function happyOrSad(tones) {
    let happy = 0;
    console.log(tones);
    tones.forEach(function (tone) {
        var score = tone["score"];
        if (tone["tone_id"] === "sadness") {
            happy -= 3 * score;
        } else if (tone["tone_id"] === "anger") {
            happy -= score;
        } else if (tone["tone_id"] === "fear") {
            happy -= score;
        } else if (tone["tone_id"] === "joy") {
            happy += 3 * score;
        } else if (tone["tone_id"] === "confident") {
            happy += score;
        }
    });
    return Math.max(-4, Math.min(Math.round(happy), 4)); // Clamp the value to [-4, 4]
}
