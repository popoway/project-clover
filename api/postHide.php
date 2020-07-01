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
  $sqlite3_filename = __DIR__."/../" . $sqlite3_filename;
  $post_id = $_POST["post_id"];
  $authuser = $_SESSION["authuser"];
  $ip_address = getClientIPAddress();
  $user_agent = $_SERVER['HTTP_USER_AGENT'];

  # Open the database connection
  $db = new SQLite3($sqlite3_filename, SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
  $query_value = 'INSERT INTO posts_hidden (post_id, created, ip_address, user_agent) VALUES (\'' . SQLite3::escapeString($post_id) . '\',\'' . gmdate('Y-m-d H:i:s') . '\',\'' . $ip_address . '\',\'' . SQLite3::escapeString($user_agent) . '\')';
  # Insert the post to database
  $db->exec('BEGIN');
  $db->query($query_value);
  $db->exec('COMMIT');

  echo 0;
  return 0;
}
?>
