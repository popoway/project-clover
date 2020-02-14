<?php
function getSqliteVersion() {
  if (extension_loaded('pdo_sqlite') && extension_loaded('sqlite3')) return "enabled";
  else return "not installed";
}
function currentAuthuserName($authuser) {
  if ($authuser == 0) return "Yeshan"; else if ($authuser == 1) return "Ming";
}
function currentPageName($page) {
  if ($page == "home") return "Home";
  else if ($page == "goals") return "Goals";
  else if ($page == "dates") return "Important Dates";
  else return null;
}
