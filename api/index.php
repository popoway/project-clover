<?php
require_once(__DIR__."/../config.php");
require_once(__DIR__."/../helper.php");

session_start();
$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); # Set the PDO error mode to exception

// Set utf8 encoding
$stmt = "SET NAMES utf8mb4";
$conn->exec($stmt);

// set mysql table prefix
$db_posts = $table_prefix . "posts";
$db_posts_hidden = $table_prefix . "posts_hidden";
$db_users = $table_prefix . "users";
