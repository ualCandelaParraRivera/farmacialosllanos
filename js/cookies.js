$(document).ready(function(){
  checkCookie("approve");
    
  $("#close-cookies").click(function(){ 
    $("#cookies").removeClass("display");
    setCookie("approve", "yes", 30);
  });
});

function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return true;
    }
  }
  return false;
}

function checkCookie() {
  var cookie=getCookie("approve");
  if (!cookie) {
    $("#cookies").addClass("display");
  }
}

function setCookie(cname,cvalue,exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires=" + d.toGMTString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}