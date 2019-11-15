const API_KEY_WATSON = "wWWmw1H_8L1Rzjj4Ulr18ufiJ3eUZkIlwUXzNjp4jQX4";

// uses Watson sentiment analysis to determine if the article is happy or sad
function sentiment(article){
    var sentimentString = ""
    sentimentString += article["title"] + ". ";
    sentimentString += article["description"];
    sentimentString += article["content"];
    sentimentString = sentimentString.replace(/(\r\n|\n|\r)/gm, " ");

    var url = "https://gateway.watsonplatform.net/tone-analyzer/api/v3/tone?version=2017-09-21&sentences=false";

    var jqxhr = $.ajax({
        url: url + '&text=' + sentimentString,
        headers: {
            'Content-Type':'application/json'
        },
        method: 'GET',
        dataType: 'json',
        disableSslVerification: true,
        beforeSend: function (xhr) {
            xhr.setRequestHeader ("Authorization", "Basic " + btoa('apikey' + ":" + API_KEY_WATSON));
        },
    });

    // Set the callback for if/when the AJAX request successfully returns
    jqxhr.done(function(data){
        console.log("analyzing " + article["title"]);
        console.log(data["document_tone"]["tones"]);
        var s = happyOrSad(data["document_tone"]["tones"]);
        article["happiness"] = s;
        if(s > 0){
            happy.push(article);
            if(isHappy){
                displayArticle(article);
            }
        }
        else if(s < 0){
            sad.push(article);
            if(!isHappy){
                displayArticle(article);
            }
        }
        //use a countdown and a timer. Possibly array of jqxhr that has a callback
    });

    // Set the callback for if/when the AJAX request fails
    jqxhr.fail(function(jqXHR){
        // jqXHR is the failed call (so we can access status, e.g.)
        console.log("Error: " + jqXHR.status);
    });
    // Set a callback to execute regardless of success or failure result
    jqxhr.always(function(){
        console.log("Done sentiment with AJAX request");
    });

    return 0;
}

// returns a positive number for happy articles and a negative number for sad articles
function happyOrSad(tones){
    var happy = 0;
    tones.forEach(function(tone){
       if(tone["tone_id"] === "sadness"){
           happy -= 1;
       }
       else if(tone["tone_id"] === "anger"){
           happy -= 1;
       }
       else if(tone["tone_id"] === "fear"){
           happy -= 1;
       }
       else if(tone["tone_id"] === "joy"){
           happy += 1;
       }
       else if(tone["tone_id"] === "confident"){
           happy += 1;
       }
    });
    return happy;
}
