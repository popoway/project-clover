<?php
require(__DIR__."/../config.php");
require(__DIR__."/../helper.php");

# Start the session
session_start();

# Reject invalid request
if ( !($_SERVER['REQUEST_METHOD'] == 'POST') ) {
  # 1 - Wrong Request Method
  echo 1;
  return 1;
}
else if ($_SESSION["signedin"] == true) {
  # 2 - Already signed in
  echo 2;
  return 2;
}
else if ( !isset($_POST["authuser"]) || empty(trim($_POST["authuser"])) || !isset($_POST["password"]) || empty(trim($_POST["password"])) ) {
  # 3 - Missing Input
  echo 3;
  return 3;
}
else {
  # Validate password
  $authuser = $_POST["authuser"];
  $password = $_POST["password"];

  $sqlite3_filename = __DIR__."/../" . $sqlite3_filename;
  $db = new SQLite3($sqlite3_filename, SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
  $sql = 'SELECT * FROM "users" WHERE authuser = ' . $authuser . ' ORDER BY "created" DESC LIMIT 1';
  $statement = $db->prepare($sql);
  $result = $statement->execute();

  while ($user = $result->fetchArray(SQLITE3_ASSOC)){
    if($user["password"] == $password) {
      # 0 - Password is correct
      $_SESSION["signedin"] = true;
      $_SESSION["authuser"] = $authuser;
      echo 0;
      return 0;
    }
    else {
      # 4 - Password is incorrect
      echo 4;
      return 4;
    }
  }
  # 4 - Authuser does not exist
  echo 4;
  return 4;
}
?>
