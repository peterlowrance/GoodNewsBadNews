$(document).ready(function() {
    // Set happiness to what it was last time
    var cookieHap = $.cookie("happiness")
    if(cookieHap){
        if(cookieHap === "happy"){
            isHappy = true;
        }
        else{
            isHappy = false;
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
