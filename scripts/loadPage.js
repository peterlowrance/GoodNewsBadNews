// Display all the news that matches with the current sentiment
function displayNews(){
    console.log("Displaying news");
    // Empty whatever was displayed
    $("#news").find('*').not('#largeArticle').remove();
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

$(document).ready(function() {
    // Set happiness to what it was last time
    let cookieHap = $.cookie("happiness");
    if(cookieHap){
        if(cookieHap === "happy"){
            isHappy = true;
        }
        else{
            isHappy = false;
            $('#toggle').bootstrapToggle('off');
        }
    }
    else{ // if there is no cookie, set it to happy
        isHappy = true;
    }
    setClasses(isHappy);
    getTopNews();

    $("#toggle").change(function () {
        isHappy = !isHappy;
        let happyString = "sad";
        if(isHappy)
        {
            happyString = "happy"
        }
        $.cookie("happiness", happyString);

        setClasses(isHappy);
        displayNews();
    });
});

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
    return '<div class="m-2 card article'+ happyString +'" style="width: ' + (isLarge? 37: 18) + 'rem;">' +
                '<a class="articleLink" href="' + article["url"] + '" style="text-decoration:none;">' +
        '<div class="view overlay zoom">' +
                    '<img src="' + article["urlToImage"] + '" class="card-img-top" alt="article photo">' +
        '</div>' +
                    '<div class="card-body">' +
                        '<h5 class="card-title">' + article["title"] + '</h5>' +
                        '<p class="card-text">' + article["description"] + '</p>' +
                    '</div>' +
                '</a>' +
            '</div>';
}
