<?php
# --------------------------------------------------------
echo "SQLite to MySQL Migration Script for Project Clover v1.1.0" . PHP_EOL;
#
# Notes:
# 1. Only schema of the user table will be migrated, you need to move user records manually
# 2. $mysql_prefix can be customized in case multiple installations exist in one database
# 3. DROP TABLE IF EXISTS -- back up accordingly, if applicable
#
# To begin migration, follow these steps:
# 1. Populate the parameters below
# 2. Set execute permission with `sudo chmod 0755 sqlite-to-mysql-migration.php`
# 2. Run script in CLI with `php sqlite-to-mysql-migration.php`
# 
# --------------------------------------------------------
# Parameters:
# Specify the location of the SQLite database
$sqlite_filename = "clover.sqlite3";
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
if (!extension_loaded('pdo_sqlite') || !extension_loaded('sqlite3')) {
  exit("Error: SQLite extension is not enabled" . PHP_EOL);
}
if (!extension_loaded('pdo_mysql') || !extension_loaded('mysqli') || !extension_loaded('mysqlnd')) {
  exit("Error: MySQL extension is not enabled" . PHP_EOL);
}

echo "Connecting to databases..." . PHP_EOL;
try {
  $sqlite = new PDO('sqlite:' . $sqlite_filename);
  echo "Connected to SQLite database $sqlite_filename" . PHP_EOL;
  $mysql = new PDO("mysql:host=$mysql_server;dbname=$mysql_database;charset=utf8", $mysql_username, $mysql_password);
  echo "Connected to MySQL server $mysql_server, database: $mysql_database" . PHP_EOL;

  // set the PDO error mode to exception
  $sqlite->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // set mysql table prefix
  $db_posts = $mysql_prefix . "posts";
  $db_posts_hidden = $mysql_prefix . "posts_hidden";
  $db_users = $mysql_prefix . "users";

  // Set utf8 encoding
  $sql = "ALTER DATABASE $mysql_database CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci";
  $mysql->exec($sql);
  echo "Set MySQL database $mysql_database utf8 encoding" . PHP_EOL;

  // clean up before creating
  $sql = "DROP TABLE IF EXISTS $db_posts";
  $mysql->exec($sql);
  $sql = "DROP TABLE IF EXISTS $db_posts_hidden";
  $mysql->exec($sql);
  $sql = "DROP TABLE IF EXISTS $db_users";
  $mysql->exec($sql);

  # 1. posts table
  $sqlite_sql = $sqlite->prepare('SELECT * FROM posts ORDER BY id ASC');
  $sqlite_sql->execute();
  $out = $sqlite_sql->fetchAll(PDO::FETCH_ASSOC);
  echo count($out) . " rows found in $sqlite_filename/posts" . PHP_EOL;

  $sql = "CREATE TABLE $db_posts (
          id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          content TEXT NOT NULL,
          authuser INT(2) UNSIGNED NOT NULL,
          created TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          ip_address TEXT,
          user_agent TEXT
  ) DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_bin";
  $mysql->exec($sql);
  echo "Table $mysql_database/$db_posts created successfully" . PHP_EOL;

  echo "Migrating posts table..." . PHP_EOL;
  foreach ($out as $post) {
    $post_id = $post["id"];
    $post_content = $mysql->quote(utf8_encode($post["content"]));
    $post_authuser = $post["authuser"];
    $post_created = $post["created"];
    $post_ip_address = $post["ip_address"];
    $post_user_agent = $mysql->quote($post["user_agent"]);
    
    $sql = "INSERT INTO $db_posts (id, content, authuser, created, ip_address, user_agent)
            VALUES ('$post_id', $post_content, '$post_authuser', '$post_created', '$post_ip_address', $post_user_agent)";
    $mysql->exec($sql);
  }
  echo count($out) . " rows inserted into $db_posts successfully" . PHP_EOL;

  # 2. posts_hidden table
  $sqlite_sql = $sqlite->prepare('SELECT * FROM posts_hidden ORDER BY id ASC');
  $sqlite_sql->execute();
  $out = $sqlite_sql->fetchAll(PDO::FETCH_ASSOC);
  echo count($out) . " rows found in $sqlite_filename/posts_hidden" . PHP_EOL;

  $sql = "CREATE TABLE $db_posts_hidden (
          id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          post_id INT(6) UNSIGNED NOT NULL,
          created TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          ip_address TEXT,
          user_agent TEXT
  )";
  $mysql->exec($sql);
  echo "Table $mysql_database/$db_posts_hidden created successfully" . PHP_EOL;

  echo "Migrating posts_hidden table..." . PHP_EOL;
  foreach ($out as $post_hidden) {
    $post_hidden_id = $post_hidden["id"];
    $post_hidden_post_id = $post_hidden["post_id"];
    $post_hidden_created = $post_hidden["created"];
    $post_hidden_ip_address = $post_hidden["ip_address"];
    $post_hidden_user_agent = $mysql->quote($post_hidden["user_agent"]);
    
    $sql = "INSERT INTO $db_posts_hidden (id, post_id, created, ip_address, user_agent)
            VALUES ('$post_hidden_id', '$post_hidden_post_id', '$post_hidden_created', '$post_hidden_ip_address', $post_hidden_user_agent)";
    $mysql->exec($sql);
  }
  echo count($out) . " rows inserted into $db_posts_hidden successfully" . PHP_EOL;

  # 3. users table
  $sqlite_sql = $sqlite->prepare('SELECT * FROM users ORDER BY id ASC');
  $sqlite_sql->execute();
  $out = $sqlite_sql->fetchAll(PDO::FETCH_ASSOC);
  echo count($out) . " rows found in $sqlite_filename/users" . PHP_EOL;

  $sql = "CREATE TABLE $db_users (
          id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          authuser INT(2) UNSIGNED NOT NULL,
          password TEXT NOT NULL,
          created TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          ip_address TEXT,
          user_agent TEXT
  )";
  $mysql->exec($sql);
  echo "Table $mysql_database/$db_users created successfully" . PHP_EOL;

  echo "Migrating users table..." . PHP_EOL;
  foreach ($out as $user) {
    // echo json_encode($user) . PHP_EOL;
    $user_id = $user["id"];
    $user_authuser = $user["authuser"];
    $user_password = $user["password"];
    $user_created = $user["created"];
    $user_ip_address = $user["ip_address"];
    $user_user_agent = $mysql->quote($user["user_agent"]);
    
    $sql = "INSERT INTO $db_users (id, authuser, password, created, ip_address, user_agent)
            VALUES ('$user_id', '$user_authuser', '$user_password', '$user_created', '$user_ip_address', $user_user_agent)";
    $mysql->exec($sql);
  }
  echo count($out) . " rows inserted into $db_users successfully" . PHP_EOL;

} catch(PDOException $e) {
  echo $sql . "\n" . $e->getMessage() . "\n";
}
echo "Closing database connections..." . PHP_EOL;
$sqlite = null;
$mysql = null;
echo "Migration completed!" . PHP_EOL;