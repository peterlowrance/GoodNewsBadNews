
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
    setClasses(happyString);
    getTopNews();

    $("#toggle").change(function () {
        isHappy = !isHappy;
        var happyString = "sad";
        if(isHappy)
        {
            happyString = "happy"
        }
        $.cookie("happiness", happyString);

        setClasses(happyString);
        displayNews();
    });
});

function setClasses(happyString){
    $("#body").attr('class', happyString + 'Body');
    $("#topBar").attr('class', 'navbar navbar-expand-md navbar-light ' + happyString + 'Top');
    $("#topBar .button").attr('class', 'm-lg-1 button btn btn-' + happyString);
    // if not logged in:
    $("#userButton").attr('class', 'disabled m-lg-1 button btn btn-' + happyString);
}

// Display all the news that matches with the current sentiment
function displayNews(){
    console.log("Displaying news");
    // Empty whatever was displayed
    $("#news").find('*').not('#largeArticle').remove();;
    $("#largeArticle").empty();
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
    if($("#largeArticle").is(':empty')){
        $("#largeArticle").append(makeArticleHTML(article, true))
    }
    else {
        $("#news").append(makeArticleHTML(article, false));
    }
}

function makeArticleHTML(article, isLarge){
    var happyString = "sad";
    if(isHappy)
    {
        happyString = "happy"
    }
    return '<div class = "article' + (isLarge? '' : ' col-lg-3 col-md-4 col-sm-6') + '"> <b/> <div class = "' + happyString +'News"><div class = "emoji">' +
        happyTypes[article["happiness"]] + '<a class = "articleLink" href="' +
        article["url"] + '" style="text-decoration:none;"></div><img src="' +
        article["urlToImage"] + '" alt="photo"/><div class = "articleData"><div class = "title">' +
        article["title"] + '</div><div id = "description" class = "' + happyString + 'Description">' + article["description"] + '</div></div></div></a></div>'
}
