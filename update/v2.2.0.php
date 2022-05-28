<?php
# --------------------------------------------------------
echo "MySQL Schema Update Script for Project Clover v2.2.0" . PHP_EOL;
#
# Notes:
# 1. $mysql_prefix can be customized in case multiple installations exist in one database
# 2. Back up accordingly, if applicable
#
# To begin migration, follow these steps:
# 1. Populate the parameters below
# 2. Set execute permission with `sudo chmod 0755 v2.2.0.php`
# 2. Run script in CLI with `php v2.2.0.php`
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
  $db_users = $mysql_prefix . "users";

  // Set utf8 encoding
  $sql = "SET NAMES utf8mb4";
  $mysql->exec($sql);
  echo "Set MySQL database $mysql_database utf8 encoding" . PHP_EOL;

  # 1. users table
  $sql = "ALTER TABLE $db_users
          ADD token text";
  $mysql->exec($sql);
  echo "Table $mysql_database/$db_users updated successfully" . PHP_EOL;

} catch(PDOException $e) {
  echo $sql . "\n" . $e->getMessage() . "\n";
}
echo "Closing database connections..." . PHP_EOL;
$mysql = null;
echo "Schema Update completed!" . PHP_EOL;