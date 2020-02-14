<?php
require("config.php");
require_once("modules/helper.php");

# Define authuser
$authuser = $_GET['authuser'];
if (!isset($authuser)) header("location:" . $site_url . "?authuser=0");

$page_title = "Home";
require("modules/head.php");
require("modules/main.php");
require("modules/feed.php");
require("modules/tail.php");
