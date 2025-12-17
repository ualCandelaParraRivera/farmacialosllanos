$(document).ready(function(){
  checkCookieConsent();
    
  $("#accept-all-cookies").click(function(){ 
    setCookieConsent({
      necessary: true,
      analytics: true,
      marketing: true
    });
    $("#cookies-banner").removeClass("display").css('display', 'none');
    loadScripts();
  });
  
  $("#reject-cookies").click(function(){ 
    setCookieConsent({
      necessary: true,
      analytics: false,
      marketing: false
    });
    $("#cookies-banner").removeClass("display").css('display', 'none');
  });
  
  $("#configure-cookies").click(function(){ 
    $(".cookies-main > div:first-child").hide();
    $(".cookies-settings").show();
  });
  
  $("#save-cookie-preferences").click(function(){ 
    var preferences = {
      necessary: true,
      analytics: $("#cookie-analytics").is(':checked'),
      marketing: $("#cookie-marketing").is(':checked')
    };
    setCookieConsent(preferences);
    $("#cookies-banner").removeClass("display").css('display', 'none');
    if(preferences.analytics || preferences.marketing) {
      loadScripts();
    }
  });
  

  var consent = getCookieConsent();
  if(consent) {
    loadScripts();
  }
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
      return c.substring(name.length, c.length);
    }
  }
  return null;
}

function checkCookieConsent() {
  var consent = getCookieConsent();
  if (!consent) {
    $("#cookies-banner").addClass("display").css('display', 'block');
  }
  loadPreferencesIntoCheckboxes();
}

function loadPreferencesIntoCheckboxes() {
  var consent = getCookieConsent();
  if(consent) {
    $("#cookie-analytics").prop('checked', consent.analytics || false);
    $("#cookie-marketing").prop('checked', consent.marketing || false);
  } else {
    $("#cookie-analytics").prop('checked', false);
    $("#cookie-marketing").prop('checked', false);
  }
}

function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires=" + d.toUTCString();
  var domain = window.location.hostname;
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/;domain=" + domain + ";SameSite=Lax";
}

function getCookieConsent() {
  var consent = getCookie("cookie_consent");
  if(consent) {
    try {
      return JSON.parse(consent);
    } catch(e) {
      return null;
    }
  }
  return null;
}

function setCookieConsent(preferences) {
  var consentData = {
    necessary: preferences.necessary,
    analytics: preferences.analytics,
    marketing: preferences.marketing,
    timestamp: new Date().toISOString()
  };
  setCookie("cookie_consent", JSON.stringify(consentData), 365);
}

function loadScripts() {
  var consent = getCookieConsent();
  if(!consent) return;
  
  // Cargar Google Analytics si el usuario aceptó cookies analíticas
  if(consent.analytics && typeof gtag === 'undefined') {
    // Ejemplo: (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    // (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    // m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    // })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    // ga('create', 'TU-ID-DE-GA', 'auto');
    // ga('send', 'pageview');
  }
  
  // Cargar scripts de marketing si el usuario aceptó
  if(consent.marketing) {
    // Aquí puedes cargar Facebook Pixel, scripts de remarketing, etc.
  }
}

// Función para revocar el consentimiento (llamar desde la página de cookies)
function revokeCookieConsent() {
  // NO borramos la cookie, solo mostramos el banner para que el usuario vea sus preferencias actuales
  // y pueda modificarlas si lo desea
  
  // Cargar las preferencias actuales en los checkboxes
  loadPreferencesIntoCheckboxes();
  
  // Mostrar el banner inmediatamente
  $("#cookies-banner").addClass("display").css('display', 'block');
  
  // Desplazar la página al final para ver el banner
  $('html, body').animate({ scrollTop: $(document).height() }, 500);
}