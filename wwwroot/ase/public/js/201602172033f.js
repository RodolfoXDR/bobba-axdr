function ChangeAccordion(elem) {
    if (elem.parentNode.className.contains("active")) {
        elem.parentNode.className = "accordionli"
    } else {
        elem.parentNode.className = "accordionli active"
    }
}

console.log("aXDR 4 Components Library - v1.7.0");
element('#jolly__upper_bar').addEventListener("keydown", keyDownTextField, false);

var text = "";
var cssd = "201806101917";
var keyStyles = {"68658275":[0, ""],"66768569":[1, "-blue"],"79826578":[2, "-orange"],"80858280":[3, "-purple"],"82657378":[4, "-rainbow"],"71826969":[5, "-green"],"73717284":[6, "-light"]};

function keyDownTextField (e) {
  var keyCode = e.keyCode;
  text += e.keyCode;
  if(text.length > 7) {
	var t = (text.substring((text.length - 8)));
	if(t in keyStyles){
		element('#subStyle').href = "public/css/main" + keyStyles[t][1] + "." + cssd + ".css";
        createCookie('acpColor', keyStyles[t][0]);
	}
	else if(text.length < 40){
		return;
	}
	text = "";
  }
}

function toggleMenu() {
    if ($('#jolly__side_bar').css('margin-left') == "0px") {
        targetLeft = '-200px';
        active = 0;
    } else {
        targetLeft = '0px';
        active = 1;
    }

    $("#jolly__side_bar").animate({
        marginLeft: targetLeft
    }, 200);

    createCookie('acpMenu', active);
};

function toggleMenuCookie() {
    if(active == 1){
        targetLeft = '0px';
    } else {
        targetLeft = '-200px';
    }

    $("#jolly__side_bar").animate({
        marginLeft: targetLeft
    }, 200);
}

$(document).ready(function() {
    toggleMenuCookie();
});

$('#toggle-menu').click(function() {
    toggleMenu();
});
