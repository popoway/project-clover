<?php
require("index.php");

# Reject invalid request
if ( !($_SERVER['REQUEST_METHOD'] == 'POST') ) {
  # 1 - Wrong Request Method
  echo 1;
  return 1;
}
else if ($_SESSION["signedin"] == false || !isset($_SESSION["signedin"])) {
  # 2 - Not signed in
  echo 2;
  return 2;
}
else if ( !isset($_POST["mainInput"]) || empty(trim($_POST["mainInput"])) ) {
  # 3 - Empty Input
  echo 3;
  return 3;
}
else {
  $content = $_POST["mainInput"];
  $authuser = $_SESSION["authuser"];
  $ip_address = getClientIPAddress();
  $user_agent = $_SERVER['HTTP_USER_AGENT'];
  
  $stmt = $conn->prepare("INSERT INTO $db_posts (content, authuser, created, ip_address, user_agent)
          VALUES (:content, :authuser, :created, :ip_address, :user_agent)");
  $stmt->bindParam(':content', $content);
  $stmt->bindParam(':authuser', $authuser);
  $stmt->bindParam(':created', gmdate('Y-m-d H:i:s'));
  $stmt->bindParam(':ip_address', $ip_address);
  $stmt->bindParam(':user_agent', $user_agent);
  
  $stmt->execute();

  $conn = null;
  echo 0;
  return 0;
}
?>
