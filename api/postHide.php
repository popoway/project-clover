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
else if ( !isset($_POST["post_id"]) || empty(trim($_POST["post_id"])) ) {
  # 3 - Empty Post ID
  echo 3;
  return 3;
}
else if ( intval($_POST["post_id"]) < 1 ) {
  # 3 - Invalid Post ID
  echo 4;
  return 4;
}
else {
  $post_id = $_POST["post_id"];
  $authuser = $_SESSION["authuser"];
  $ip_address = getClientIPAddress();
  $user_agent = $_SERVER['HTTP_USER_AGENT'];

  $stmt = $conn->prepare("INSERT INTO $db_posts_hidden (post_id, created, ip_address, user_agent)
          VALUES (:post_id, :created, :ip_address, :user_agent)");
  $stmt->bindParam(':post_id', $post_id);
  $stmt->bindParam(':created', gmdate('Y-m-d H:i:s'));
  $stmt->bindParam(':ip_address', $ip_address);
  $stmt->bindParam(':user_agent', $user_agent);

  $stmt->execute();

  $conn = null;
  echo 0;
  return 0;
}
?>
