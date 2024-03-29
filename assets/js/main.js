/**
 * Array containing structured posts requested from API.
 */
let posts = [], postsLikes = [];
/**
 * Array denoting the range of currently loaded posts on page, as postsIndex[min, max].
 * @param {integer} min The smallest index of posts.
 * @param {integer} max The largest index of posts.
 */
let postsIndex = [null, null];
let postsLoading = false;

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

/**
 * Check if the specified module exists on the page.
 * @param {string} module Name of the module.
 * @returns True if the module exists, or false if the modue does not exist.
 */
function moduleExists(module) {
  return document.querySelector(`#${module}`) != null;
}

/**
 * Generate localized feed date string.
 * @param {string} date Date string from API to parse.
 * @returns Localized date string.
 */
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
  if (evt != null || evt != undefined) evt.preventDefault();
  $.ajax({url: "/api/signout.php", type: "POST",
  success: function(result){
    location.href = "/index.php?page=signin&continue=" + getUrlParam('page', 'home') + "&signedout=1";
  },
  error: function(xhr){
    alert("A server side error occured: " + xhr.status + " " + xhr.statusText + "\nPlease try again later.");
  }});
}

function asyncChangePassword(evt) {
  evt.preventDefault();
  document.querySelector("#changePassword").classList.add('was-validated');
  let valid = true;
  if (document.querySelector("#currentPassword").value === "") {
    document.querySelector("#currentPassword + .invalid-feedback").textContent = "Please enter current password.";
    valid = false;
  }
  if (document.querySelector("#newPassword").value === "") {
    document.querySelector("#newPassword + .invalid-feedback").textContent = "Please enter new password.";
    valid = false;
  }
  if (document.querySelector("#confirmPassword").value === "") {
    document.querySelector("#confirmPassword + .invalid-feedback").textContent = "Please confirm new password.";
    valid = false;
  }
  if (document.querySelector("#confirmPassword").value != document.querySelector("#newPassword").value) {
    document.querySelector("#changePassword").classList.remove('was-validated');
    document.querySelector("#currentPassword").classList.add('is-valid');
    document.querySelector("#newPassword").classList.add('is-invalid');
    document.querySelector("#confirmPassword").classList.add('is-invalid');
    document.querySelector("#confirmPassword + .invalid-feedback").textContent = "New password does not match confirm password.";
    valid = false;
  }
  if (!valid) return;
  else {
    // Form style before ajax
    document.querySelector(".btn-primary").disabled = true;
    const loadingButton = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Updating...';
    document.querySelector(".btn-primary").innerHTML = loadingButton;
    // ajax
    const currentPassword = document.querySelector("#currentPassword").value;
    const newPassword = document.querySelector("#newPassword").value;
    $.ajax({
      url: "/api/changePassword.php", type: "POST", data: { current_password: currentPassword, new_password: newPassword },
      success: function (result) {
        if (result === "0") {
          alert("Your password has been updated. Use your new password to sign in.")
          asyncSignout(null);
        }
        else {
          document.querySelector(".btn-primary").disabled = false;
          document.querySelector(".btn-primary").innerHTML = 'Change Password';
          document.querySelector("#changePassword").classList.remove('was-validated');
          document.querySelector("#currentPassword").classList.add('is-invalid');
          let msg = 'Callback Error message';
          if (result === "1") {
            msg = 'Wrong Request Method';
          }
          else if (result === "2") {
            msg = 'You have not already signed in. Maybe clear browser cookies and try again?';
          }
          else if (result === "3") {
            msg = 'Current password is incorrect.';
          }
          else if (result === "4") {
            msg = 'authuser / password is missing on the server side.';
          }
          else {
            msg = `Error: ${result}`;
          }
          document.querySelector("#currentPassword + .invalid-feedback").textContent = msg;
        }
      },
      error: function (xhr) {
        alert("A server side error occured: " + xhr.status + " " + xhr.statusText + "\nPlease try again later.");
      }
    });
  }
}

function wordCount(){
  var c = $("#mainInput").val().length;
  if (c == 0) $("#mainInputHelp").text("随便说点什么吧～😉");
  else $("#mainInputHelp").text("Word Count: " + c);
}

function asyncPostUpload(evt) {
  evt.preventDefault();
  // Frontend validation
  document.querySelector("#mainForm").classList.add('was-validated');
  if (document.querySelector("#mainInput").value === "") {
    document.querySelector(".invalid-feedback").textContent = "没有内容的动态不是好动态 🤭";
    return;
  }
  else {
    // Form style before ajax
    document.querySelector("#mainInputHelp").style.display = "none";
    document.querySelector(".btn-primary").disabled = true;
    document.querySelector(".btn-primary").style.width = "auto";
    document.querySelector(".btn-secondary").style.display = "none";
    const loadingButton = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>发表中...';
    document.querySelector(".btn-primary").innerHTML = loadingButton;
    // ajax
    const mainInput = document.querySelector("#mainInput").value;
    $.ajax({url: "/api/postUpload.php", type: "POST", data: {mainInput: mainInput},
    success: function(result){
      if (result === "0") {
        const successButton = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>发表成功';
        document.querySelector(".btn-primary").innerHTML = successButton;
        setTimeout(function(){ location.href = "/index.php?page=home"; }, 150);
      }
      else {
        document.querySelector("#mainInputHelp").style.removeProperty('display');
        document.querySelector(".btn-primary").disabled = false;
        document.querySelector(".btn-primary").innerHTML = '发表';
        document.querySelector(".btn-secondary").style.removeProperty('display');
        document.querySelector("#signinPassword").classList.remove('was-validated');
        document.querySelector("#signinInputPassword").classList.add('is-invalid');
        let msg = 'Callback Error message';
        if (result === "1") {
          msg = 'Wrong Request Method';
        }
        else if (result === "2") {
          msg = 'You did not sign in. Why not sign in and try again?';
        }
        else if (result === "3") {
          msg = 'mainInput is missing on the server side.';
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

function wordCountOnReset(){
  $("#mainInputHelp").text("随便说点什么吧～😉");
}

/**
 * Asynchronously remove a post.
 * @param {*} evt The event which triggers this function.
 */
function asyncPostRemove(evt) {
  evt.preventDefault();
  if (confirm("Are you sure you want to remove this post? This action cannot be undone.")) {
    const currentPost = evt.target.parentElement.parentElement.parentElement.parentElement;
    const post_id = currentPost.getAttribute("id").replace(/[^0-9]/g, '');
    // console.log("Try to remove post_id: " + post_id);
    $.ajax({url: "/api/postHide.php", type: "POST", data: {post_id: post_id},
    success: function(result){
      if (result === "0") {
        currentPost.style.display = "none";
        alert(`Post #${post_id} has been successfully removed.`)
      }
      else {
        let msg = 'Callback Error message';
        if (result === "1") {
          msg = 'Wrong Request Method';
        }
        else if (result === "2") {
          msg = 'You did not sign in. Why not sign in and try again?';
        }
        else if (result === "3") {
          msg = 'mainInput is missing on the server side.';
        }
        else if (result === "4") {
          msg = 'The post_id you requested is invalid. Try reload the page.';
        }
        else {
          msg = `Error: ${result}`;
        }
        alert(msg);
        console.log(msg);
      }
    },
    error: function(xhr){
      alert("A server side error occured: " + xhr.status + " " + xhr.statusText + "\nPlease try again later.");
    }});
  }
  else {
    alert("You have cancelled the action. No post is removed.");
  }
}

/**
 * Look up authuser by username.
 * @param {string} name The username used to look up authuser id.
 * @returns Authuser id. If no matching authuser is found, return -1.
 */
function currentAuthuserId(name) {
  if (name === null || name === undefined) name = document.getElementById("mainFormName").textContent;
  switch (name) {
    case "Yeshan":
      return 0;
    case "Ming":
      return 1;
    default:
      return -1;
  }
}

/**
 * Look up username by authuser.
 * @param {number} authuser The authuser id used to look up username.
 * @returns Matching username. If no matching username is found, return null.
 */
function currentAuthuserName(authuser) {
  if (authuser === null || authuser === undefined) return document.getElementById("mainFormName").textContent;
  switch (parseInt(authuser)) {
    case 0:
      return "Yeshan";
    case 1:
      return "Ming";
    default:
      return null;
  }
}

/**
 * Asynchronously like a post.
 * @param {*} evt The event which triggers this function.
 */
function asyncPostLike(evt) {
  evt.preventDefault();
  const currentPost = evt.target.parentElement.parentElement.parentElement.parentElement;
  const post_id = currentPost.getAttribute("id").replace(/[^0-9]/g, '');
  let action = null, add_like = null;
  if (currentPost.getElementsByClassName(`feed-likes-authuser-${currentAuthuserId()}`).length > 0) {
    action = "unlike";
    add_like = 0;
  } else {
    action = "like";
    add_like = 1;
  }
  console.log(`Try to ${action} post_id: ${post_id}`);
  $.ajax({
    url: "/api/postLike.php", type: "POST", data: { post_id: post_id, add_like: add_like },
    success: function (result) { 
      if (result === "0") {
        window.location.reload();
      }
      else {
        let msg = 'Callback Error message';
        if (result === "1") {
          msg = 'Wrong Request Method';
        }
        else if (result === "2") {
          msg = 'You did not sign in. Why not sign in and try again?';
        }
        else if (result === "3") {
          msg = 'mainInput is missing on the server side.';
        }
        else if (result === "4") {
          msg = 'The post_id you requested is invalid. Try reload the page.';
        }
        else {
          msg = `Error: ${result}`;
        }
        alert(msg);
        console.log(msg);
      }
    },
    error: function (xhr) {
      alert("A server side error occured: " + xhr.status + " " + xhr.statusText + "\nPlease try again later.");
    }
  });
}

/**
 * Asynchronously load post likes from the API and add to global postLikes[].
 */
function asyncPostLikeLoad() {
  fetch(`/api/asyncLoad.php?type=post_like`)
    .then(response => response.json())
    .then(data => {
      postsLikes = data.payload;
    });
}

/**
 * Asynchronously load the post from the API and add to / update global posts[] and page.
 * @param {integer} skip The number of post skipped before the first loaded post.
 * @param {integer} limit The number of post loaded in total.
 */
function asyncPostLoad(skip, limit) {
  if (!postsLoading) {
    postsLoading = true;

    fetch(`/api/asyncLoad.php?skip=${skip}&limit=${limit}`)
      .then(response => response.json())
      .then(data => {
        const loadedPosts = data.payload;
        for (let post of loadedPosts) {
          post.createdDateObject = new Date(`${post.created.substr(0, 10)}T${post.created.substr(11, 8)}Z`); // UTC Conversion to JS Object
          // Update existing post stored in posts[], if applicable
          const doesPostExist = (element) => element.id === post.id;
          const i = posts.findIndex(doesPostExist);
          if (i !== -1) {
            posts.splice(i, 1); // remove one item, starting i
          }
          posts.push(post);

          // Update posts range
          if (postsIndex[0] === null) postsIndex[0] = post.id;
          if (postsIndex[1] === null) postsIndex[1] = post.id;
          if (post.id < postsIndex[0]) postsIndex[0] = post.id;
          if (post.id > postsIndex[1]) postsIndex[1] = post.id;

          let postTable = document.createElement("table");
          postTable.classList.add("feed-table");
          postTable.setAttribute("tabindex", "0");
          postTable.setAttribute("id", `feedPost_${post.id}`);
          // Post table authuser - row1
          let tr1 = document.createElement("tr");
          let th1 = document.createElement("th");
          th1.setAttribute("rowspan", "2");
          th1.classList.add("feed-avatar");
          let img = document.createElement("img");
          img.setAttribute("src", `/assets/img/authuser_${post.authuser}.jpg`);
          img.setAttribute("title", `Avatar of ${currentAuthuserName(post.authuser)}`);
          img.setAttribute("alt", `Avatar of ${currentAuthuserName(post.authuser)}`);
          img.setAttribute("class", "img-thumbnail rounded");
          img.setAttribute("width", "72");
          tr1.appendChild(th1);
          th1.appendChild(img);
          let th2 = document.createElement("th");
          let h3 = document.createElement("h3");
          h3.classList.add("feed-username");
          h3.setAttribute("title", `Post sent by ${currentAuthuserName(post.authuser)}`);
          h3.append(currentAuthuserName(post.authuser));
          th2.appendChild(h3);
          tr1.appendChild(th2);
          postTable.appendChild(tr1);
          // Post table date - row2
          let tr2 = document.createElement("tr");
          let td1 = document.createElement("td");
          let datestr = localizeFeedDate(post.createdDateObject.toISOString());
          td1.setAttribute("title", `Post composed on ${datestr} (${post.createdDateObject.toString()})`);
          td1.classList.add("feed-date");
          td1.append(datestr);
          tr2.appendChild(td1);
          postTable.appendChild(tr2);
          // Post table content - row3
          let tr3 = document.createElement("tr");
          let td2 = document.createElement("td");
          td2.classList.add("feed-content-left");
          td2.setAttribute("colspan", "1");
          tr3.appendChild(td2);
          let td3 = document.createElement("td");
          td3.setAttribute("title", "Post Content");
          td3.classList.add("feed-content");
          td3.setAttribute("colspan", "2");
          td3.append(post.content);
          tr3.appendChild(td3);
          postTable.appendChild(tr3);
          // Post table actions - row4
          let tr4 = document.createElement("tr");
          let td4 = document.createElement("td");
          td4.classList.add("feed-actions");
          td4.setAttribute("colspan", "3");
          let div = document.createElement("div");
          div.setAttribute("class", "btn-group d-flex");
          div.setAttribute("role", "group");
          div.setAttribute("aria-label", "Post Actions");
          let button1 = document.createElement("button");
          button1.setAttribute("class", "btn btn-outline-primary btn-sm w-100 feed-action-like");
          button1.append("Like");
          button1.addEventListener("click", asyncPostLike);
          div.appendChild(button1);
          let button2 = document.createElement("button");
          button2.setAttribute("class", "btn btn-outline-primary btn-sm w-100 feed-action-comment");
          button2.setAttribute("disabled", "");
          button2.append("Comment");
          div.appendChild(button2);
          if (currentAuthuserId() === parseInt(post.authuser)) {
            let button3 = document.createElement("button");
            button3.setAttribute("class", "btn btn-outline-danger btn-sm w-100 feed-action-remove");
            button3.append("Remove");
            button3.addEventListener("click", asyncPostRemove);
            div.appendChild(button3);
          }
          td4.appendChild(div);
          tr4.appendChild(td4);
          postTable.appendChild(tr4);
          // Post likes - row5
          let tr5 = document.createElement("tr");
          let td5 = document.createElement("td");
          td5.classList.add("feed-likes");
          td5.setAttribute("colspan", "3");
          for (let like of postsLikes) {
            if (like.post_id === post.id && parseInt(like.liked) != 0){
              let span = document.createElement("span");
              span.setAttribute("class", `feed-likes-authuser-${like.authuser}`);
              span.textContent = `💙 ${currentAuthuserName(parseInt(like.authuser))}`;
              td5.appendChild(span);
            }
          }
          tr5.appendChild(td5);
          postTable.appendChild(tr5);

          document.querySelector("#feed").querySelector(".col-lg-6").insertBefore(postTable, document.querySelector(".feed-infinite-scroll"));

          postsLoading = false;
        }
      });
  }
}

/**
 * Checks whether the app is run as webapp in iOS.
 * @returns {boolean} Boolean value indicating whether the app is run as webapp in iOS.
 */
function webappDetect() {
  return (("standalone" in window.navigator) && window.navigator.standalone);
}

let darkModeMQL = window.matchMedia("(prefers-color-scheme: dark)");
darkModeMQL.addEventListener("change", (e) => {
  if (e.matches) {
    /* Dark Mode on */
    document.querySelector('nav').classList.replace("navbar-light", "navbar-dark");
    let buttons = document.querySelectorAll('button');
    for (let button of buttons) {
      button.classList.replace("btn-outline-danger", "btn-danger");
    }

  } else {
    /* Dark Mode off */
    document.querySelector('nav').classList.replace("navbar-dark", "navbar-light");
    let buttons = document.querySelectorAll('button');
    for (let button of buttons) {
      button.classList.replace("btn-danger", "btn-outline-danger");
    }
  }
})

window.addEventListener("DOMContentLoaded", (event) => {
  if (darkModeMQL.matches) {
    document.querySelector('nav').classList.replace("navbar-light", "navbar-dark");
    let buttons = document.querySelectorAll('button');
    for (let button of buttons) {
      button.classList.replace("btn-outline-danger", "btn-danger");
    }
  }
  if (getUrlParam("page", null) == "home") {
    asyncPostLikeLoad();
    asyncPostLoad(0, 10);
    if (document.querySelector(".feed-infinite-scroll") != null) {
      $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
          setTimeout(() => {asyncPostLoad(posts.length, 10)}, Math.floor(Math.random() * 1000));
          if (postsIndex[0] == 1 && document.querySelector(".feed-infinite-scroll") !== null) {
            document.querySelector(".feed-infinite-scroll").remove();
          }
        }
      });
    }
  }
});

$(document).ready(function(){
  if (!moduleExists("signin")) {
    document.querySelector("#navbarSignout").addEventListener("click", asyncSignout, false);
  }
  if (moduleExists("signin")) {
    // signin-avatar-picker
    const avatars = document.querySelectorAll(".signin-avatar-picker-choice");
    for (let avatar of avatars) {
      avatar.addEventListener("click", authuserSpecifier);
      avatar.addEventListener("keyup", (event) => {
        // 13 => (Enter) , 32 => (space) key on the keyboard
        if (event.keyCode === 13 || event.keyCode === 32) {
          event.preventDefault();
          event.target.querySelector("span").click();
        }
      });
    }
    document.querySelector("#signinPassword").addEventListener("submit", asyncSignin, false);
    document.querySelector("#signinInputPassword").addEventListener("input", () => {
      document.querySelector("#signinPassword").classList.remove('was-validated');
      document.querySelector("#signinInputPassword").classList.remove('is-invalid');
    }, false);
    document.querySelector('.btn-secondary').addEventListener("click", (event) => {
      event.preventDefault();
      document.getElementById("signinPassword").style.removeProperty('display');
    });
    if (getUrlParam('signedout', '0') === "1") alert("You have successfully signed out.");
  }
  if (moduleExists("settingsDashboard")) {
    document.querySelector("#changePassword").addEventListener("submit", asyncChangePassword, false);
    document.querySelector("#currentPassword").addEventListener("input", () => {
      document.querySelector("#changePassword").classList.remove('was-validated');
      document.querySelector("#currentPassword").classList.remove('is-invalid');
      document.querySelector("#newPassword").classList.remove('is-invalid');
      document.querySelector("#confirmPassword").classList.remove('is-invalid');
    }, false);
    document.querySelector("#newPassword").addEventListener("input", () => {
      document.querySelector("#changePassword").classList.remove('was-validated');
      document.querySelector("#currentPassword").classList.remove('is-invalid');
      document.querySelector("#newPassword").classList.remove('is-invalid');
      document.querySelector("#confirmPassword").classList.remove('is-invalid');
    }, false);
    document.querySelector("#confirmPassword").addEventListener("input", () => {
      document.querySelector("#changePassword").classList.remove('was-validated');
      document.querySelector("#currentPassword").classList.remove('is-invalid');
      document.querySelector("#newPassword").classList.remove('is-invalid');
      document.querySelector("#confirmPassword").classList.remove('is-invalid');
    }, false);
  }
  if (moduleExists("main")) {
    // construct EventListener for mainInput for wordCount
    document.getElementById("mainInput").addEventListener("input", wordCount);
    // async post upload
    document.getElementById("mainForm").addEventListener("submit", asyncPostUpload, false);
    document.querySelector("#mainInput").addEventListener("input", () => {
      document.querySelector("#mainForm").classList.remove('was-validated');
      document.querySelector("#mainInput").classList.remove('is-invalid');
      document.querySelector("#mainInputHelp").style.removeProperty('display');
    }, false);
  }
  if (moduleExists("feed")) {
    // Parse UTC feed date to local date
    $(".feed-date").each(function(index){
      $(this).text(localizeFeedDate($(this).text()));
    });
    const likeButton = document.querySelectorAll(".feed-action-like");
    for (let i = 0; i < likeButton.length; i++) {
      likeButton[i].addEventListener("click", asyncPostLike);
    }
    const removeButton = document.querySelectorAll(".feed-action-remove");
    for (let i = 0; i < removeButton.length; i++) {
      removeButton[i].addEventListener("click", asyncPostRemove);
    }
  }
});

function literalUserAgent(){
  MicroMessenger
}
