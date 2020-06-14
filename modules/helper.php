<?php
function getSqliteVersion() {
  if (extension_loaded('pdo_sqlite') && extension_loaded('sqlite3')) return "enabled";
  else return "not installed";
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
  if ($page == "home") return "Home";
  else if ($page == "goals") return "Goals";
  else if ($page == "dates") return "Important Dates";
  else if ($page == "mobileconfig") return "Shortcut";
  else return null;
}
