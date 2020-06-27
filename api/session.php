<?php
session_start();
if (!isset($_SESSION["signedin"])) {
  $_SESSION["signedin"] = false;
}
echo json_encode($_SESSION);
return 0;
?>
