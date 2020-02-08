$(document).ready(function() {
//change CAPTCHA on each click or on refreshing page
$("#captchareload").click(function() {

$("img#captchaimg").remove();
var id = Math.random();
$('<img id="captchaimg" src="lib/captcha/captcha.php?id='+id+'"/>').appendTo("#captchaimgdiv");
id ='';
});

});