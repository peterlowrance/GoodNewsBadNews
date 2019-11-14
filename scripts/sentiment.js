const API_KEY_WATSON = "wWWmw1H_8L1Rzjj4Ulr18ufiJ3eUZkIlwUXzNjp4jQX4";
// Returns 1 for happy, -1 for sad, and 0 otherwise
function sentiment(article, callback){
    console.log("checking sentiment of article");
    var sentimentString = ""
    sentimentString += article["title"] + ". ";
    sentimentString += article["description"];
    sentimentString += article["content"];
    sentimentString = sentimentString.replace(/(\r\n|\n|\r)/gm, " ");
    console.log(sentimentString);

    var url = "https://gateway.watsonplatform.net/tone-analyzer/api/v3/tone?version=2017-09-21&sentences=false";
    var auth = 'Basic ' + btoa('apikey' + ':' + API_KEY_WATSON);
    //console.log(auth);
    var jqxhr = $.ajax({
        url: url + '&text=' + sentimentString,
        headers: {
            //'Authorization': auth,
            'Content-Type':'application/json'
        },
        method: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
            xhr.setRequestHeader ("Authorization", "Basic " + btoa('apikey' + ":" + API_KEY_WATSON));
        },
        //data: {text: sentimentString},
        /*success: function(data){
            console.log('succ');
            console.log(data);
        }*/
    });

    // Set the callback for if/when the AJAX request successfully returns
    jqxhr.done(function(data){
        var s = happyOrSad(data["document_tone"]["tones"]);
        if(s > 0){
            happy.push(data);
        }
        else if(s < 0){
            sad.push(data);
        }
        displayArticle(article["title"] + " : " + s); //use a countdown and a timer. Possibly array of jqxhr that has a callback
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

function happyOrSad(tones){
    var happy = 0;
    tones.forEach(function(tone){
       console.log(tone);
       if(tone["tone_id"] === "sadness"){
           console.log('sad ' + tone["score"]);
           happy -= 1;
       }
       else if(tone["tone_id"] === "anger"){
           console.log('anger ' + tone["score"]);
           happy -= 1;
       }
       else if(tone["tone_id"] === "fear"){
           console.log('fear ' + tone["score"]);
           happy -= 1;
       }
       else if(tone["tone_id"] === "joy"){
           console.log('joy ' + tone["score"]);
           happy += 1;
       }
       else if(tone["tone_id"] === "confident"){
           console.log('confident ' + tone["score"]);
           happy += 1;
       }
    });
    console.log("Calculated happiness: " + happy);
    return happy;
}
