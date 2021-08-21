String.prototype.contains = function(it) { return this.indexOf(it) != -1; };
String.prototype.StartsWith = function(it) { return this.indexOf(it) == 0; };
Element.prototype.remove = function() { this.parentElement.removeChild(this); }
NodeList.prototype.remove = HTMLCollection.prototype.remove = function() {
    for(var i = 0, len = this.length; i < len; i++) {
        if(this[i] && this[i].parentElement) {
            this[i].parentElement.removeChild(this[i]);
        }
    }
}

var date = new Date();
xmlhttp = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");

function is_numeric(input){
	return typeof(input)=='number';
}
		
function get(uri, type, fCallback, args){
	xmlhttp.open(type, uri, true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.callback = fCallback;
	xmlhttp.onload = xhrSuccess;
	xmlhttp.send(args + "&GUID=" + GUID + "&uid=" + uid);
}


function get2(uri, type, args){
	xmlhttp.open(type, uri, false);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(args + "&GUID=" + GUID + "&uid=" + uid);

	return xmlhttp.responseText;
}

function xhrSuccess (){
	this.callback.apply(this, this.arguments);
}

function showAsyncAlert(m){
	alert(this.responseText);
}

function element(name){
	return (name.StartsWith("#")) ? document.getElementById(name.substr(1)) : document.getElementsByClassName(name.substr(1));
}

function h2d(pStr) {
    tempstr = '';
    for (b = 0; b < pStr.length; b = b + 2) {
        tempstr = tempstr + String.fromCharCode(parseInt(pStr.substr(b, 2), 16));
    }
    return tempstr;
}

function b2h(s) {
	var i, l, o = "", n;
	s += "";

	for (i = 0, l = s.length; i < l; i++) {
		n = s.charCodeAt(i).toString(16)
		o += n.length < 2 ? "0" + n : n;
	}

	return o;
}

function NewDialog(Title, Summary, Body, Buttons){
	var HTML = '<div id="overlay" class="overlay"></div><div id="alert" class="alert overall"><div class="alert__heading">';
	HTML += Title;
	HTML += '</div><div class="alert__subheading">';
	HTML += Summary;
	HTML += '</div><div class="alert__body">';
	HTML += Body;
	HTML += '</div><div class="alert__buttons">';
	HTML += Buttons;
	HTML += '</div></div>';
	element("#junk").innerHTML += HTML;
}

function CloseDialog(){
	(elem=element("#alert")).parentNode.removeChild(elem);
	(elem=element("#overlay")).parentNode.removeChild(elem);
}

function changeRotator (i) {
	element('#content_' + rotatorId).className = "rotatorItem rotatorOld";
	element('#content_' + i).className = "rotatorItem rotatorCurrent";
	element('#thumb_' + rotatorId).className = "rotatorThumb rotatorThumbOff";
	element('#thumb_' + i).className = "rotatorThumb rotatorThumbOn";
	rotatorId = i;
}

function createCookie(name, value) {
	t = date;
	t.setTime(t.getTime()+(24*60*60*1000*14));
	document.cookie = name + '=' + value + '; expires=' + t.toGMTString() + '; path=/'
}

function ChangeMenuButtons(SaveText, SaveLink, ExtraText, ExtraLink) {
	if(SaveText == ""){
		element("#menuSave").style.visibility = "hidden";
	}else{
		element("#menuSave").style.visibility = "visible";
		element("#menuSave").innerHTML = SaveText;
		element("#menuSave").onclick = SaveLink;
	}

	if(ExtraText == ""){
		element("#menuOptional").style.visibility = "hidden";
	}else{
		element("#menuOptional").style.visibility = "visible";
		element("#menuOptional").innerHTML = ExtraText;
		element("#menuOptional").onclick = ExtraLink;
	}
}

function ChangePage(pageId){
	if(pageId == "next"){
		pageId = parseInt(element("#nowPage").value) + parseInt(1);
		element("#nowPage").value = pageId;
	}else if(pageId == "back"){
		pageId = parseInt(element("#nowPage").value) - parseInt(1);
		element("#nowPage").value = pageId;
	}else if(pageId == "first"){
		pageId = 1;
		element("#nowPage").value = pageId;
	}else if(pageId == "last"){
		pageId = Math.round(parseInt(element("#usersTotal").value) / parseInt(element("#resultCount").value)) + 1;
		element("#nowPage").value = pageId;
	}
	
	if(is_numeric(pageId) && pageId > -2){
		var sValue = element('#i0120').value;
		if(sValue.indexOf("<!-- ") == -1){
			sValue = "<!-- page:" + pageId + " -->" + sValue;
			element("#i0120").value = sValue;
		} else {
			if(sValue.indexOf("page:") == -1){
				sValue = sValue.replace("<!-- ", "<!-- page:" + pageId + ";");
				element("#i0120").value = sValue;
			} else {
				var oldNumber = sValue.split("page:")[1];
				oldNumber = (oldNumber.indexOf(";") == -1) ? oldNumber.split(" ")[0] : oldNumber.split(";")[0];

				sValue = sValue.replace("page:" + oldNumber, "page:" + pageId);
				element("#i0120").value = sValue;
			}
		}
	}

	SCHclick();

	var sValue = element('#i0120').value;
	var limitPages = 15;

	if(sValue.indexOf("limit:") != -1){
		var limitPages = sValue.split("limit:")[1];
		if(limitPages.indexOf(";") == -1){
			limitPages = limitPages.split(" ")[0];
		}
		else{
			limitPages = limitPages.split(";")[0];
		}
	}
}

function OrderBy(column){
	var sValue = element('#i0120').value;
	if(sValue.indexOf("<!-- ") == -1){
		sValue = "<!-- orderby:" + column + " -->" + sValue;
	} else {
		if(sValue.indexOf("orderby:") == -1){
			sValue = sValue.replace("<!-- ", "<!-- orderby:" + column + ";");
		} else {
			var oldValue = sValue.split("orderby:")[1];
			oldValue = (oldValue.indexOf(";") == -1) ? oldValue.split(" ")[0] : oldValue.split(";")[0];

			sValue = sValue.replace("orderby:" + oldValue, "orderby:" + column);
		}
	}
	
	if(sValue.indexOf("order:") == -1){
		sValue = sValue.replace("<!-- ", "<!-- order:DESC;");
	} else {
		var oldValue = sValue.split("order:")[1];
		oldValue = (oldValue.indexOf(";") == -1) ? oldValue.split(" ")[0] : oldValue.split(";")[0];

		sValue = sValue.replace("order:" + oldValue, "order:" + (oldValue == "DESC" ? "ASC" : "DESC"));
	}
	
	element("#i0120").value = sValue;
	SCHclick();
}

function ChangeImage(eId, eId2, dStr) {
	element("#" + eId).src = element("#" + eId2).value + dStr;
}