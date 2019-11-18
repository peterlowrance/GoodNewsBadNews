const API_KEY = "ad166f4252f544f38678b331fc373fff";
var happy = new Array;
var sad = new Array;
var isHappy = true;

// Gets all the news and then partitions it
function getTopNews() {
    console.log("Getting top news");
    var url = "https://newsapi.org/v2/top-headlines?country=us&pageSize=100&apiKey=" + API_KEY;
    var jqxhr = $.get(url);
    // Set the callback for if/when the AJAX request successfully returns
    jqxhr.done(function(data){
        partitionNews(data);
    });

    // Set the callback for if/when the AJAX request fails
    jqxhr.fail(function(jqXHR){
        console.log("Error: " + jqXHR.status);
    });
    // Set a callback to execute regardless of success or failure result
    jqxhr.always(function(){
        console.log("Done with news AJAX request");
    });
}

// Use the sentiment of each article to partition it into happy and sad articles
function partitionNews(allNews) {
    allNews["articles"].forEach(function(data){
        sentiment(data);
    });
}

// Display all the news that matches with the current sentiment
function displayNews(){
    console.log("Displaying news");
    // Empty whatever was displayed
    $("#news").empty();
    if(isHappy){
        happy.forEach(function(a){
           displayArticle(a);
        });
    }
    else{
        sad.forEach(function(a){
            displayArticle(a);
        });
    }
}

// Display a single article
function displayArticle(article){
    $("#news").append('<li>Title: ' + article["title"] + '<ul><li>Description: ' +
        article["description"] + '</li><li>Content: ' +
        article["content"] + '</li><li>Happiness: ' +
        article["happiness"] + '</li></ul></li>');
}

$(document).ready(function() {
    $("#fetchNews").click(function () {
        isHappy = true;
        getTopNews();
    });
    $("#toggle").click(function () {
        isHappy = !isHappy;
        displayNews();
    });
});
