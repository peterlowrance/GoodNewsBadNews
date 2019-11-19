const API_KEY = "ad166f4252f544f38678b331fc373fff";
var happy = new Array;
var sad = new Array;
var isHappy;
var happyTypes = {};
happyTypes[-4] = "😭";
happyTypes[-3] = "😢";
happyTypes[-2] = "☹️";
happyTypes[-1] = "🙁";
happyTypes[0] = "😐";
happyTypes[1] = "🙂";
happyTypes[2] = "😃";
happyTypes[3] = "😁";
// Gets all the news and then partitions it
function getTopNews() {
    console.log("Getting top news");
    var url = "https://newsapi.org/v2/top-headlines?country=us&pageSize=100&apiKey=" + API_KEY;
    var jqxhr = $.get(url);
    // Set the callback for if/when the AJAX request successfully returns
    jqxhr.done(function(data){
        data["articles"].forEach(function(article){
            // If the article is saved in cache, load its happiness
            var hap = $.cookie(article["title"].substring(0, 15));
            if(hap){
                article["happiness"] = hap;
            }
            sentiment(article);
        });
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
    var happyString = "sad";
    if(isHappy)
    {
      happyString = "happy"
    }
    $("#news").append('<div class = "article"> <b/> <div class = "' + happyString +'News"><div class = "emoji">' +
    happyTypes[article["happiness"]] + '<a class = "articleLink" href="' +
		article["url"] + '" style="text-decoration:none;"></div><img src="' +
		article["urlToImage"] + '" alt="photo"/><div class = "title">' +
		article["title"] + '</div></div></a></div>');
}

$(document).ready(function() {
    // Set happiness to what it was last time
    var cookieHap = $.cookie("happiness")
    if(cookieHap){
        if(cookieHap === "happy"){
            isHappy = true;
        }
        else{
            isHappy = false;
            $('#toggle').bootstrapToggle('off')
        }
    }
    else{ // if there is no cookie, set it to happy
        isHappy = true;
    }
    var happyString = "sad";
    if(isHappy)
    {
      happyString = "happy"
    }
    $("#body").attr('class', happyString + 'Body');
    $("#topBar").attr('class', happyString + 'Top');
    $('#topButton').attr('class', happyString + 'Button');
    getTopNews();

    $("#toggle").change(function () {
        isHappy = !isHappy;
        $.cookie("happiness", isHappy? "happy" : "sad");
        console.log($.cookie("happiness"));
        var happyString = "sad";
        if(isHappy)
        {
          happyString = "happy"
        }
        $("#body").attr('class', happyString + 'Body');
        $("#topBar").attr('class', happyString + 'Top');
        displayNews();
    });
});
