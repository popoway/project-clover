<?php
$development_mode = "develop";

if ($development_mode == "develop") {
  $site_url = "https://project-clover.app.popoway.cloud";
}
elseif ($development_mode == "production") {
  $site_url = "http://yeshan.ming.fyi";
}

$cdn_url = "https://static.popoway.me/ajax/libs";
