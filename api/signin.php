<?php
require("index.php");

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
else if ( !isset($_POST["authuser"]) || (trim($_POST["authuser"])=="") || !isset($_POST["password"]) || empty(trim($_POST["password"])) ) {
  # 3 - Missing Input
  echo 3;
  return 3;
}
else {
  # Validate password
  $authuser = $_POST["authuser"];
  $password = $_POST["password"];

  $stmt = $conn->prepare("SELECT * FROM $db_users WHERE authuser = :authuser ORDER BY created DESC LIMIT 1");
  $stmt->bindParam(':authuser', $authuser);

  $stmt->execute();

  while ($user = $stmt->fetch(PDO::FETCH_ASSOC)){
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

  $conn = null;
}
?>
