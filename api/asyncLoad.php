<?php
require("index.php");

header("Content-Type: application/json");
$response = array();
$code = 200;
$message = 'success';
$type = 'post';
$content = array();
$skip = 0;
$limit = 10;
if ( isset($_GET["type"]) && (!empty(trim($_GET["type"]))) ) {
  $type = trim($_GET["type"]);
}
if ( isset($_GET["skip"]) && (!empty(trim($_GET["skip"]))) ) {
  $skip = trim($_GET["skip"]);
}
if ( isset($_GET["limit"]) && (!empty(trim($_GET["limit"]))) ) {
  $limit = trim($_GET["limit"]);
}
# Reject invalid request
if ($_SESSION["signedin"] == false || !isset($_SESSION["signedin"])) {
  # Not signed in
  $code = 400;
  $message = 'not signed in';
}
else if ($type == 'post') { 
  $stmt = $conn->prepare("SELECT * FROM $db_posts WHERE id NOT IN (SELECT post_id FROM $db_posts_hidden) ORDER BY created DESC LIMIT $limit OFFSET $skip");
  $stmt->execute();
  $content = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $conn = null;
} else if ($type == 'post_like') {
  $stmt = $conn->prepare("SELECT * FROM $db_posts_likes WHERE id IN ( SELECT MAX(id) FROM $db_posts_likes GROUP BY authuser, post_id) ORDER BY created ASC");
  $stmt->execute();
  $content = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $conn = null;
}
$response = array(
  'code' => $code,
  'message' => $message,
  'timestamp' => time(),
  'content' => $content
);
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
