<?php
require_once("config.php");
require_once("helper.php");

# Set error reporting level
if (PC_ENV != 'production') {
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
} 
else {
  error_reporting(0);
  ini_set("display_errors", 0);
}

# Start the session
session_start();

# Define authuser (0,1)
if (!empty($_SESSION)) {
  $signedin = $_SESSION['signedin'];
  $authuser = $_SESSION['authuser'];
}

# Define current page (home,goals.dates)
$page = $_GET['page'];
if (!isset($page)) {
  if (!isset($page)) $page = "home";
  header("location:" . PC_SITEURL . "?page=" . $page);
}

# Redirect if not signed in
if (!signedin() && ($page != "signin")) {
  header("location:" . PC_SITEURL . "?page=signin&continue=" . $page);
}
if (($page == "signin") && empty($_GET['continue'])) {
  header("location:" . PC_SITEURL . "?page=signin&continue=home");
}
if (signedin() && ($page == "signin")) {
  if (!isset($_GET['continue']) || $_GET['continue'] === "home") header("location:" . PC_SITEURL . "?page=home");
  else header("location:" . PC_SITEURL . "?page=" . $_GET['continue']);
}

# Generate page content
$page_title = currentPageName($page);
require("modules/head.php");
if ($page == "signin") require("modules/signin.php");
if ($page == "home") {
  require("modules/main.php");
  require("modules/feed.php");
}
else if ($page == "goals") require("modules/goals.php");
else if ($page == "dates") require("modules/dates.php");
else if ($page == "mobileconfig") require("modules/mobileconfig.php");
require("modules/tail.php");
