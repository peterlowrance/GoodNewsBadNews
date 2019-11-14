const API_KEY = "ad166f4252f544f38678b331fc373fff";
var happy = new Array;
var sad = new Array;
var isHappy = true;

function getTopNews() {
    console.log("Getting top news");
    var url = "https://newsapi.org/v2/top-headlines?country=us&apiKey=" + API_KEY;
    var jqxhr = $.get(url);
    // Set the callback for if/when the AJAX request successfully returns
    jqxhr.done(function(data){
        partitionNews(data, displayNews);
        // Needs to wait for partition to finish
        //displayNews();
    });

    // Set the callback for if/when the AJAX request fails
    jqxhr.fail(function(jqXHR){
        // jqXHR is the failed call (so we can access status, e.g.)
        console.log("Error: " + jqXHR.status);
    });
    // Set a callback to execute regardless of success or failure result
    jqxhr.always(function(){
        console.log("Done with news AJAX request");
    });
}

function partitionNews(allNews, callback) {
    // Test code that just does the first article
    /*console.log("partitioning news");
    //var s =
    sentiment(allNews["articles"].pop(), callback);
    /!*if(s > 0){
        happy.push(data);
    }
    else if(s < 0){
        sad.push(data);
    }*!/
    console.log("finished partitioning news");*/
    // Real code
    allNews["articles"].forEach(function(data){
        var s = sentiment(data, callback);
        /*if(s > 0){
            happy.push(data);
        }
        else if(s < 0){
            sad.push(data);
        }*/
    });
}

function displayNews(){
    console.log("Displaying news");
    if(isHappy){
        //console.log(happy);
        $("#news").html(happy.toString());
    }
    else{
        $("#news").html(sad.toString());
    }
}

function displayArticle(article){
    $("#news").append('<li>' + article + '</li>');
}

$(document).ready(function() {
    $("#loadNews").click(function () {
        getTopNews();
        console.log("called");
    });
});
