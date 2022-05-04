<?php
require("index.php");

# Reject invalid request
if ( !($_SERVER['REQUEST_METHOD'] == 'POST') ) {
  # 1 - Wrong Request Method
  echo 1;
  return 1;
}
else if ( !($_SESSION["signedin"] == true) ) {
  # 2 - Not signed in
  echo 2;
  return 2;
}
else {
  # Validate password
  $authuser = $_SESSION["authuser"];
  $current_password = $_POST["current_password"];

  $stmt = $conn->prepare("SELECT * FROM $db_users WHERE authuser = :authuser ORDER BY created DESC LIMIT 1");
  $stmt->bindParam(':authuser', $authuser);

  $stmt->execute();

  while ($user = $stmt->fetch(PDO::FETCH_ASSOC)){
    if($user["password"] == $current_password) {
      # 0 - Password is correct
      $new_password = $_POST["new_password"];
      $ip_address = getClientIPAddress();
      $user_agent = $_SERVER['HTTP_USER_AGENT'];
      
      $stmt = $conn->prepare("INSERT INTO $db_users (authuser, password, created, ip_address, user_agent)
              VALUES (:authuser, :password, :created, :ip_address, :user_agent)");
      $stmt->bindParam(':authuser', $authuser);
      $stmt->bindParam(':password', $new_password);
      $stmt->bindParam(':created', gmdate('Y-m-d H:i:s'));
      $stmt->bindParam(':ip_address', $ip_address);
      $stmt->bindParam(':user_agent', $user_agent);
      
      $stmt->execute();
      $conn = null;
      echo 0;
      return 0;
    }
    else {
      # 3 - Password is incorrect
      $conn = null;
      echo 3;
      return 3;
    }
  }
  # 4 - Authuser does not exist
  $conn = null;
  echo 4;
  return 4;
}
?>
