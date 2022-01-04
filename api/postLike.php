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
  # 4 - Invalid Post ID
  echo 4;
  return 4;
}
else if ( !isset($_POST["add_like"]) || empty(trim($_POST["add_like"])) ) {
  # 5 - Empty Like Action: 1 = Add Like, 0 = Remove Like
  echo 5;
  return 5;
}
else if ( $_POST["add_like"] != 0 && $_POST["add_like"] != 1 ) {
  # 5 - Invalid Like Action
  echo 5;
  return 5;
}
else {
  $post_id = $_POST["post_id"];
  $add_like = $_POST["add_like"];
  $authuser = $_SESSION["authuser"];
  $ip_address = getClientIPAddress();
  $user_agent = $_SERVER['HTTP_USER_AGENT'];

  $stmt = $conn->prepare("INSERT INTO $db_posts_likes (post_id, liked, authuser, created, ip_address, user_agent)
          VALUES (:post_id, :liked, :authuser, :created, :ip_address, :user_agent)");
  $stmt->bindParam(':post_id', $post_id);
  $stmt->bindParam(':liked', $add_like, PDO::PARAM_INT);
  $stmt->bindParam(':authuser', $authuser);
  $stmt->bindParam(':created', gmdate('Y-m-d H:i:s'));
  $stmt->bindParam(':ip_address', $ip_address);
  $stmt->bindParam(':user_agent', $user_agent);
  var_dump($post_id);
  var_dump($add_like);
  $stmt->execute();

  $conn = null;
  echo 0;
  return 0;
}
?>
