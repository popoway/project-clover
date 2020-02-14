<?php
function getSqliteVersion() {
  if (function_exists('sqlite_open')) return "loaded";
  else return "not installed";
}
