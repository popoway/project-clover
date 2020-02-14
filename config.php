<?php
# Specify the development mode
$development_mode = "develop";

# Define Site URL
if ($development_mode == "develop") {
  $site_url = "https://project-clover.app.popoway.cloud";
}
elseif ($development_mode == "production") {
  $site_url = "http://yeshan.ming.fyi";
}

#Define CDN URL
$cdn_url = "https://static.popoway.me/ajax/libs";

# Specify the location and filename of the SQLite3 database
$sqlite3_filename = "clover.sqlite3";
