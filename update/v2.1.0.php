<?php
# --------------------------------------------------------
echo "MySQL Schema Update Script for Project Clover v2.1.0" . PHP_EOL;
#
# Notes:
# 1. $mysql_prefix can be customized in case multiple installations exist in one database
# 2. DROP TABLE IF EXISTS -- back up accordingly, if applicable
#
# To begin migration, follow these steps:
# 1. Populate the parameters below
# 2. Set execute permission with `sudo chmod 0755 v2.1.0.php`
# 2. Run script in CLI with `php v2.1.0.php`
# 
# --------------------------------------------------------
# Parameters:
# Specify MySQL server connection
$mysql_server = "database.popoway.cloud";
$mysql_database = "project_clover";
$mysql_username = "project_clover_user";
$mysql_password = "password";
$mysql_prefix = "pc_";
# --------------------------------------------------------

echo "Checking environment..." . PHP_EOL;
if (version_compare(PHP_VERSION, '5.6.0') < 0) {
  exit("Error: Update to PHP version 5.6.0 or above to continue. Current version: " . PHP_VERSION . PHP_EOL);
}
if (!extension_loaded('pdo_mysql') || !extension_loaded('mysqli') || !extension_loaded('mysqlnd')) {
  exit("Error: MySQL extension is not enabled" . PHP_EOL);
}

echo "Connecting to databases..." . PHP_EOL;
try {
  $mysql = new PDO("mysql:host=$mysql_server;dbname=$mysql_database;charset=utf8mb4", $mysql_username, $mysql_password);
  echo "Connected to MySQL server $mysql_server, database: $mysql_database" . PHP_EOL;

  // set the PDO error mode to exception
  $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // set mysql table prefix
  $db_posts = $mysql_prefix . "posts";
  $db_posts_comments = $mysql_prefix . "posts_comments";
  $db_posts_likes = $mysql_prefix . "posts_likes";

  // Set utf8 encoding
  $sql = "SET NAMES utf8mb4";
  $mysql->exec($sql);
  $sql = "ALTER DATABASE $mysql_database CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci";
  $mysql->exec($sql);
  echo "Set MySQL database $mysql_database utf8 encoding" . PHP_EOL;

  // clean up before creating
  $sql = "DROP TABLE IF EXISTS $db_posts_comments";
  $mysql->exec($sql);
  $sql = "DROP TABLE IF EXISTS $db_posts_likes";
  $mysql->exec($sql);

  # 1. posts_comments table
  $sql = "CREATE TABLE $db_posts_comments (
          id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          post_id INT(6) UNSIGNED FOREIGN KEY REFERENCES 
          content TEXT NOT NULL,
          authuser INT(2) UNSIGNED NOT NULL,
          created TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          ip_address TEXT,
          user_agent TEXT
  ) DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_bin";
  $mysql->exec($sql);
  echo "Table $mysql_database/$db_posts_comments created successfully" . PHP_EOL;

  echo "Migrating posts_comments table...";
  foreach ($out as $post) {
    $post_id = $post["id"];
    $post_content = $mysql->quote($post["content"]);
    $post_authuser = $post["authuser"];
    $post_created = $post["created"];
    $post_ip_address = $post["ip_address"];
    $post_user_agent = $mysql->quote($post["user_agent"]);
    $sql = "INSERT INTO $db_posts_comments (id, content, authuser, created, ip_address, user_agent)
            VALUES ('$post_id', $post_content, '$post_authuser', '$post_created', '$post_ip_address', $post_user_agent)";
    $mysql->exec($sql);
    if ($post_id % 100 == 1) echo $post_id . "...";
  }
  echo "Done." . PHP_EOL . count($out) . " rows inserted into $db_posts_comments successfully" . PHP_EOL;

  # 2. posts_likes table
  $sqlite_sql = $sqlite->prepare('SELECT * FROM posts_likes ORDER BY id ASC');
  $sqlite_sql->execute();
  $out = $sqlite_sql->fetchAll(PDO::FETCH_ASSOC);
  echo count($out) . " rows found in $sqlite_filename/posts_likes" . PHP_EOL;

  $sql = "CREATE TABLE $db_posts_likes (
          id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          post_id INT(6) UNSIGNED NOT NULL,
          created TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          ip_address TEXT,
          user_agent TEXT
  )";
  $mysql->exec($sql);
  echo "Table $mysql_database/$db_posts_likes created successfully" . PHP_EOL;

  echo "Migrating posts_likes table..." . PHP_EOL;
  foreach ($out as $post_hidden) {
    $post_hidden_id = $post_hidden["id"];
    $post_hidden_post_id = $post_hidden["post_id"];
    $post_hidden_created = $post_hidden["created"];
    $post_hidden_ip_address = $post_hidden["ip_address"];
    $post_hidden_user_agent = $mysql->quote($post_hidden["user_agent"]);
    
    $sql = "INSERT INTO $db_posts_likes (id, post_id, created, ip_address, user_agent)
            VALUES ('$post_hidden_id', '$post_hidden_post_id', '$post_hidden_created', '$post_hidden_ip_address', $post_hidden_user_agent)";
    $mysql->exec($sql);
  }
  echo count($out) . " rows inserted into $db_posts_likes successfully" . PHP_EOL;

} catch(PDOException $e) {
  echo $sql . "\n" . $e->getMessage() . "\n";
}
echo "Closing database connections..." . PHP_EOL;
$mysql = null;
echo "Schema Update completed!" . PHP_EOL;