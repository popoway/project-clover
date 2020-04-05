<?php
require("config.php");
require_once("modules/helper.php");

# Environment check
if (getSqliteVersion() != "enabled") die("SQLite3 must be installed and enabled on the server to use the app.");

# If POST then upload it
# if (isset($_POST["authuser"])) include("modules/feedUpload.php");

# Define authuser (0,1)
$authuser = $_GET['authuser'];
# Define current page (home,goals.dates)
$page = $_GET['page'];

if (!isset($authuser) || !isset($page)) {
  if (!isset($authuser)) $authuser = 0;
  if (!isset($page)) $page = "home";
  header("location:" . $site_url . "?authuser=" . $authuser . "&page=" . $page);
}

# Generate page content
$page_title = currentPageName($page);
require("modules/head.php");
if ($page == "home") {
  require("modules/main.php");
  require("modules/feed.php");
}
else if ($page == "goals") require("modules/goals.php");
else if ($page == "dates") require("modules/dates.php");
require("modules/tail.php");
