function loadLook() {
    var xmlhttp;
    var n = $('#credentials\\.username').val();
    var x = $('#welcome__username');

    if (n == '') {
        x.html('');
    } else {
        x.html(n);
    }

    if(n == '') {
        $('#user__figure__img').attr('src', 'https://habbo.es/habbo-imaging/avatarimage?figure=hd-180-1.ch-255-66.lg-280-110.sh-305-62.ha-1012-110.hr-828-61&action=wlk,wav&direction=4&head_direction=3&gesture=sml&size=m');
        return;
    }

    if(window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.open("POST", "/habbo-imaging/changeLook?username=" + n, true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send();

    xmlhttp.onreadystatechange = function() {
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var Obj = JSON.parse(xmlhttp.responseText);
            $('#user__figure__img').attr('src', Obj.look);
            return;
        }
    }
}

