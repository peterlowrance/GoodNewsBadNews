const API_KEY = "ad166f4252f544f38678b331fc373fff";
var happy = new Array;
var sad = new Array;
var isHappy = true;

function getTopNews() {
    var url = "https://newsapi.org/v2/top-headlines?country=us&apiKey=" + API_KEY;
    var jqxhr = $.get(url);
    // Set the callback for if/when the AJAX request successfully returns
    jqxhr.done(function(data){
        partitionNews(data);
        // Needs to wait for partition to finish
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
    });
}

function partitionNews(allNews) {
    // Test code that just does the first article
    var s = sentiment(allNews["articles"].pop());
    if(s > 0){
        happy.push(data);
    }
    else if(s < 0){
        sad.push(data);
    }
    // Real code
    /*allNews["articles"].forEach(function(data){
        var s = sentiment(data);
        if(s > 0){
            happy.push(data);
        }
        else if(s < 0){
            sad.push(data);
        }
    });*/
}

function displayNews(isHappy){
    console.log(happy);
    console.log("display");
    if(isHappy){
        //console.log(happy);
        $("div").html(happy.toString());
    }
    else{
        $("div").html(sad.toString());
    }
}


$(document).ready(function() {
   getTopNews();
   console.log("called");
});
