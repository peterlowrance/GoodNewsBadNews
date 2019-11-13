const API_KEY_WATSON = "wWWmw1H_8L1Rzjj4Ulr18ufiJ3eUZkIlwUXzNjp4jQX4";
// Returns 1 for happy, -1 for sad, and 0 otherwise
function sentiment(article){
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
        url: url,
        headers: {
            //'Authorization': auth,
            'Content-Type':'application/json'
        },
        method: 'POST',
        dataType: 'json',
        beforeSend: function (xhr) {
            xhr.setRequestHeader ("Authorization", "Basic " + btoa('apikey' + ":" + API_KEY_WATSON));
        },
        data: {"text": sentimentString},
        success: function(data){
            console.log('success: ' + data);
        }
    });
    //var jqxhr = $.post(url, {"text": sentimentString});
    // Set the callback for if/when the AJAX request successfully returns
    /*jqxhr.done(function(data){
        partitionNews(data);
        displayNews(isHappy);
    });

    // Set the callback for if/when the AJAX request fails
    jqxhr.fail(function(jqXHR){
        // jqXHR is the failed call (so we can access status, e.g.)
        console.log("Error: " + jqXHR.status);
    });
    // Set a callback to execute regardless of success or failure result
    jqxhr.always(function(){
        console.log("Done with AJAX request");
    });*/

    return 1;
}
