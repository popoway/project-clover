<?php
# Is page title specified?
if (!isset($page_title)) $page_title = "Untitled";
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, shrink-to-fit=no">
  <meta name="description" content="Project Clover web application.">
  <meta name="keywords" content="Ming, Yeshan, love, relationship, goals">
  <meta name="author" content="popoway">
  <!-- Load fav and touch icons -->
  <link rel="shortcut icon" href="<?php echo $site_url; ?>/assets/img/Icon-60@3x.png?ver=<?php echo CVER; ?>">
  <!-- iOS integration -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="default">
  <meta name="apple-mobile-web-app-title" content="Project Clover">
  <meta name="format-detection" content="telephone=no">
  <link rel="apple-touch-icon" sizes="192x192" href="/assets/img/touchicon_192px.png?ver=<?php echo CVER; ?>">

  <link rel="stylesheet" href="<?php echo $cdn_url; ?>/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
  <link rel="stylesheet" href="<?php echo $site_url; ?>/assets/css/main.css?ver=<?php echo CVER; ?>">
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
        <li class="nav-item <?php if ($page == "home") echo 'active'; ?>">
          <a class="nav-link" href="./?page=home">Home</a>
        </li>
        <li class="nav-item <?php if ($page == "goals") echo 'active'; ?>">
          <a class="nav-link" href="./?page=goals">Our Goals</a>
        </li>
        <li class="nav-item <?php if ($page == "dates") echo 'active'; ?>">
          <a class="nav-link" href="./?page=dates">Cool Dates</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            产品…?
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="https://github.com/popoway/project-clover/wiki/TODO" target="_blank">产品经理的需求</a>
            <a class="dropdown-item" href="https://github.com/popoway/project-clover/releases" target="_blank">发行日志</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="./?authuser=<?php echo $authuser; ?>&page=mobileconfig">Install iOS app</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="javascript:alert('没错，这个链接啥功能也木有 😛')">Very Very Suspicious 👀</a>
        </li>
      </ul>
      <?php if ($_SESSION["signedin"]) {
        ?>
      <span class="navbar-text">
        Signed in as
        <span id="navbarUsername">
          <?php echo currentAuthuserName($_SESSION["authuser"]); ?>
        </span>
        <a href="javascript:void(0)">Sign out</a>
      </span>
        <?php
      } else {
        ?>
      <span class="navbar-text">
        You have not signed in.
      </span>
        <?php
      }?>
    </div>
  </nav>
