
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
    setClasses(isHappy);
    getTopNews();

    $("#toggle").change(function () {
        isHappy = !isHappy;
        var happyString = "sad";
        if(isHappy)
        {
            happyString = "happy"
        }
        $.cookie("happiness", happyString);

        setClasses(isHappy);
        displayNews();
    });
});

function setClasses(isHappy){
    if(isHappy){
        $("#body").removeClass("sadBody");//('class', happyString + 'Body');
        $("#body").addClass("happyBody");
        $("#topBar").removeClass("sadTop");//('class', 'navbar navbar-expand-md navbar-light ' + happyString + 'Top');
        $("#topBar").addClass("happyTop");
        $("#topBar .button").removeClass("btn-sad");//.attr('class', 'm-lg-1 button btn btn-' + happyString);
        $("#topBar .button").addClass("btn-happy");
        // if not logged in:
        $("#userButton").removeClass("btn-sad");//.attr('class', 'disabled m-lg-1 button btn btn-' + happyString);
        $("#userButton").addClass("btn-happy");
    }
    else{
        $("#body").removeClass("happyBody");//('class', happyString + 'Body');
        $("#body").addClass("sadBody");
        $("#topBar").removeClass("happyTop");//('class', 'navbar navbar-expand-md navbar-light ' + happyString + 'Top');
        $("#topBar").addClass("sadTop");
        $("#topBar .button").removeClass("btn-happy");//.attr('class', 'm-lg-1 button btn btn-' + happyString);
        $("#topBar .button").addClass("btn-sad");
        // if not logged in:
        $("#userButton").removeClass("btn-happy");//.attr('class', 'disabled m-lg-1 button btn btn-' + happyString);
        $("#userButton").addClass("btn-sad");
    }
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
    return '<div class="card m-2" style="width: ' + (isLarge? 37: 18) + 'rem;">' +
                '<a class="articleLink" href="' + article["url"] + '" style="text-decoration:none;">' +
                    '<img src="' + article["urlToImage"] + '" class="card-img-top" alt="article photo">' +
                    '<div class="card-body">' +
                        '<h5 class="card-title">' + article["title"] + '</h5>' +
                        '<p class="card-text">' + article["description"] + '</p>' +
                    '</div>' +
                '</a>' +
            '</div>';
    /*return '<div class = "article' + (isLarge? ' col-lg-9 col-md-12 col-sm-15' : ' col-lg-3 col-md-4 col-sm-6') + '"> <b/>'+
        '<div class = "' + happyString +'News">' +
          '<a class = "articleLink" href="' + article["url"] + '" style="text-decoration:none;">' +
            '<div class = "emoji">' + happyTypes[article["happiness"]] + '</div>' +
            '<div class = "headerData">'+
              '<div>' +
                '<img src="' + article["urlToImage"] + '" alt="photo"/>' +
              '</div>' +
              '<div class = "title">' + article["title"] + '</div>' +
            '</div>' +
            '<div id = "description" class = "' + happyString + 'Description">' + article["description"] + '</div>' +
          '</a></div></div>'*/
}
