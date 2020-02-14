<?php
require(__DIR__."/../config.php");
$sqlite3_filename = __DIR__."/../" . $sqlite3_filename;
$content = $_POST["mainInput"];
$authuser = $_POST["authuser"];
//whether ip is from share internet
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
  $ip_address = $_SERVER['HTTP_CLIENT_IP'];
}
//whether ip is from proxy
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
  $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
}
//whether ip is from remote address
else {
  $ip_address = $_SERVER['REMOTE_ADDR'];
}
$user_agent = $_SERVER['HTTP_USER_AGENT'];

# Open the database connection
$db = new SQLite3($sqlite3_filename, SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
$query_value = "INSERT INTO \"posts\" (\"content\", \"authuser\", \"created\", \"ip_address\", \"user_agent\") VALUES (\"" . $content . "\", \"" . $authuser . "\", \"" . date('Y-m-d H:i:s') . "\", \"" . $ip_address . "\", \"" . SQLite3::escapeString($user_agent) . "\")";
# Insert the post to database
$db->exec('BEGIN');
$db->query($query_value);
# REMEMBER TO SET UP SQLite WRITE (e.g. 777) PERMISSION PROPERLY!!!
$db->exec('COMMIT');
header("location:" . $site_url . "?authuser=" . $authuser . "&page=home");
?>
