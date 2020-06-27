function getUrlVars() {
  var vars = {};
  var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
    vars[key] = value;
  });
  return vars;
}

function getUrlParam(parameter, defaultvalue){
  var urlparameter = defaultvalue;
  if(window.location.href.indexOf(parameter) > -1){
    urlparameter = getUrlVars()[parameter];
  }
  return urlparameter;
}

function moduleExists(module) {
  return document.querySelector(`#${module}`) != null;
}

function localizeFeedDate(date){
  var msec = Date.parse(date); // Parse date string to unix milliseconds
  var d = new Date(msec); // Then convert it to a date object
  var dateString =
    d.getFullYear() + "-" +
    ("0" + (d.getMonth()+1)).slice(-2) + "-" +
    ("0" + d.getDate()).slice(-2) + " " +
    ("0" + d.getHours()).slice(-2) + ":" +
    ("0" + d.getMinutes()).slice(-2) + ":" +
    ("0" + d.getSeconds()).slice(-2);
  return dateString;
}

function authuserSpecifier(evt){
  document.getElementById("signinPassword").style.display = "block";
  const user = evt.target.parentNode.querySelector("span").textContent;
  document.querySelector("#signinInputPassword").placeholder = user + "\'s Password 🔑";
  if (user === "Yeshan") document.querySelector("#signinInputAuthuser").value = 0;
  else if (user === "Ming") document.querySelector("#signinInputAuthuser").value = 1;
  document.querySelector("#signinInputPassword").value = "";
  document.querySelector("#signinPassword").classList.remove('was-validated');
}

function asyncSignin(evt) {
  evt.preventDefault();
  // Frontend validation
  document.querySelector("#signinPassword").classList.add('was-validated');
  if (document.querySelector("#signinInputPassword").value === "") {
    document.querySelector(".invalid-feedback").textContent = "Please enter a password.";
    return;
  }
  else {
    // Form style before ajax
    // document.querySelector("#signinInputPassword").disabled = true;
    document.querySelector(".btn-primary").disabled = true;
    document.querySelector(".btn-secondary").style.display = "none";
    const loadingButton = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Authenticating...';
    document.querySelector(".btn-primary").innerHTML = loadingButton;
    // ajax
    const authuser = document.querySelector("#signinInputAuthuser").value;
    const password = document.querySelector("#signinInputPassword").value;
    $.ajax({url: "/api/signin.php", type: "POST", data: {authuser: authuser, password: password},
    success: function(result){
      if (result === "0") location.href = "/index.php?page=" + getUrlParam('continue', 'home');
      else {
        document.querySelector(".btn-primary").disabled = false;
        document.querySelector(".btn-primary").innerHTML = 'Sign in';
        document.querySelector(".btn-secondary").style.removeProperty('display');
        document.querySelector("#signinPassword").classList.remove('was-validated');
        document.querySelector("#signinInputPassword").classList.add('is-invalid');
        let msg = 'Callback Error message';
        if (result === "1") {
          msg = 'Wrong Request Method';
        }
        else if (result === "2") {
          msg = 'You have already signed in. Maybe clear browser cookies and try again?';
        }
        else if (result === "3") {
          msg = 'authuser / password is missing on the server side.';
        }
        else if (result === "4") {
          msg = 'Authentication has failed due to incorrect password.';
        }
        else {
          msg = `Error: ${result}`;
        }
        document.querySelector(".invalid-feedback").textContent = msg;
      }
    },
    error: function(xhr){
      alert("A server side error occured: " + xhr.status + " " + xhr.statusText + "\nPlease try again later.");
    }});
  }
}

function asyncSignout(evt) {
  evt.preventDefault();
  $.ajax({url: "/api/signout.php", type: "POST",
  success: function(result){
    location.href = "/index.php?page=signin&continue=" + getUrlParam('page', 'home') + "&signedout=1";
  },
  error: function(xhr){
    alert("A server side error occured: " + xhr.status + " " + xhr.statusText + "\nPlease try again later.");
  }});
}

function wordCount(){
  var c = $("#mainInput").val().length;
  if (c == 0) $("#mainInputHelp").text("随便说点什么吧～😉");
  else $("#mainInputHelp").text("Word Count: " + c);
}

function wordCountOnReset(){
  $("#mainInputHelp").text("随便说点什么吧～😉");
}

$(document).ready(function(){
  if (!moduleExists("signin")) {
    document.querySelector(".navbar-text a").addEventListener("click", asyncSignout, false);
  }
  if (moduleExists("signin")) {
    // signin-avatar-picker
    const avatar = document.querySelectorAll(".signin-avatar-picker-choice");
    for (let i = 0; i < avatar.length; i++) {
      avatar[i].addEventListener("click", authuserSpecifier);
    }
    document.querySelector("#signinPassword").addEventListener("submit", asyncSignin, false);
    document.querySelector("#signinInputPassword").addEventListener("input", function(){
      document.querySelector("#signinPassword").classList.remove('was-validated');
      document.querySelector("#signinInputPassword").classList.remove('is-invalid');
    }, false);
    if (getUrlParam('signedout', '0') === "1") alert("You have successfully signed out.");
  }
  if (moduleExists("main")) {
    // construct EventListener for mainInput for wordCount
    document.getElementById("mainInput").addEventListener("input", wordCount);
  }
  if (moduleExists("feed")) {
    // Parse UTC feed date to local date
    $(".feed-date").each(function(index){
      $(this).text(localizeFeedDate($(this).text()));
    });
  }
});

function literalUserAgent(){
  MicroMessenger
}
