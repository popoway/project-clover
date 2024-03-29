<?php
require_once("config.php");

# Specify the app version.
define("PC_VER", file_get_contents("VERSION"));

function getSqliteVersion() {
  if (extension_loaded('pdo_sqlite') && extension_loaded('sqlite3')) return "enabled";
  else return "not installed";
}

function getMySQLVersion() {
  if (!extension_loaded('pdo_mysql') || !extension_loaded('mysqli') || !extension_loaded('mysqlnd')) return "not installed";
  else return "enabled";
}

function getClientIPAddress() {
  // whether ip is from share internet
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip_address = $_SERVER['HTTP_CLIENT_IP'];
  }
  // whether ip is from proxy
  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
  // whether ip is from remote address
  else {
    $ip_address = $_SERVER['REMOTE_ADDR'];
  }
  return $ip_address;
}

function signedin() {
  # Requires Session session_start();
  return (isset($_SESSION["signedin"]) && $_SESSION["signedin"] == true);
}

function currentAuthuserName($authuser) {
  switch ($authuser) {
    case 0:
      return "Yeshan";
      break;
    case 1:
      return "Ming";
      break;
    default:
      return null;
      break;
  }
}

function currentPageName($page) {
  switch ($page) {
    case "home":
      return "Home";
      break;
    case "goals":
      return "Goals";
      break;
    case "dates":
      return "Important Dates";
      break;
    case "mobileconfig":
      return "Shortcut";
      break;
    case "signin":
      return "Sign in";
      break;
    case "settings-dashboard":
      return "Settings";
      break;
    case "settings-otp":
      return "One-time Password Settings";
      break;
    default:
      return null;
      break;
  }
}

function loadResourceFrom($where, $what) {
  $enver = PC_VER;
  if (PC_ENV != "production") $enver = md5(uniqid());
  if ($where == "cdn") return PC_CDNURL . $what;
  else if ($where == "site") return PC_SITEURL . $what . "?ver=" . $enver;
}
