<?php
# Is page title specified?
if (!isset($page_title)) $page_title = "Untitled";
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="<?php echo $cdn_url; ?>/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
  <link rel="stylesheet" href="<?php echo $site_url; ?>/assets/css/main.css">
  <title><?php echo $page_title; ?> - Project Clover</title>
</head>
<body>
  <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
    <a class="navbar-brand" href="#">🍀 Project Clover</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Our Goals</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Cool Dates</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Very Very Suspicious 👀</a>
        </li>
      </ul>
      <span class="navbar-text">
        Signed in as
        <span id="navbarUsername">
          <?php if ($authuser == 0) echo "string"; else if ($authuser == 1) echo "string2"; ?>
        </span>
        <a href="<?php if ($authuser == 0) echo $site_url. "?authuser=1"; else if ($authuser == 1) echo $site_url. "?authuser=0"; ?>">Switch User</a>
      </span>
    </div>
  </nav>
