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
  <link rel="shortcut icon" href="<?php echo loadResourceFrom('site', '/assets/img/Icon-60@3x.png'); ?>">
  <!-- iOS integration -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="theme-color" content="white" media="(prefers-color-scheme: light)">
  <meta name="theme-color" content="black" media="(prefers-color-scheme: dark)">
  <meta name="apple-mobile-web-app-status-bar-style" media="(prefers-color-scheme: light)" content="default" />
  <meta name="apple-mobile-web-app-status-bar-style" media="(prefers-color-scheme: dark)" content="dark-content" />
  <meta name="apple-mobile-web-app-title" content="<?php if (PC_ENV == "production") {echo "Project Clover";} else {echo "pc_" . PC_ENV;} ?>">
  <meta name="format-detection" content="telephone=no">
  <link rel="apple-touch-icon" sizes="192x192" href="<?php echo loadResourceFrom('site', '/assets/img/touchicon_192px.png'); ?>">
  <link href="<?php echo loadResourceFrom('site', '/assets/img/splashscreens/iphone5_splash.png'); ?>" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
  <link href="<?php echo loadResourceFrom('site', '/assets/img/splashscreens/iphone6_splash.png'); ?>" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
  <link href="<?php echo loadResourceFrom('site', '/assets/img/splashscreens/iphoneplus_splash.png'); ?>" media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
  <link href="<?php echo loadResourceFrom('site', '/assets/img/splashscreens/iphonex_splash.png'); ?>" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
  <link href="<?php echo loadResourceFrom('site', '/assets/img/splashscreens/iphonexr_splash.png'); ?>" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
  <link href="<?php echo loadResourceFrom('site', '/assets/img/splashscreens/iphonexsmax_splash.png'); ?>" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
  <link href="<?php echo loadResourceFrom('site', '/assets/img/splashscreens/iphone12mini_splash.png'); ?>" media="(device-width: 360px) and (device-height: 780px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
  <link href="<?php echo loadResourceFrom('site', '/assets/img/splashscreens/iphone12pro_splash.png'); ?>" media="(device-width: 390px) and (device-height: 844px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
  <link href="<?php echo loadResourceFrom('site', '/assets/img/splashscreens/iphone12promax_splash.png'); ?>" media="(device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
  <link href="<?php echo loadResourceFrom('site', '/assets/img/splashscreens/ipad_splash.png'); ?>" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
  <link href="<?php echo loadResourceFrom('site', '/assets/img/splashscreens/ipadpro1_splash.png'); ?>" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
  <link href="<?php echo loadResourceFrom('site', '/assets/img/splashscreens/ipadpro3_splash.png'); ?>" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
  <link href="<?php echo loadResourceFrom('site', '/assets/img/splashscreens/ipadpro2_splash.png'); ?>" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
  <link rel="stylesheet" href="<?php echo loadResourceFrom('cdn', '/bootstrap/4.4.1/css/bootstrap.min.css'); ?>" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
  <link rel="stylesheet" href="<?php echo loadResourceFrom('site', '/assets/css/main.css'); ?>">
  <title><?php echo $page_title; ?> - Project Clover <?php if (PC_ENV != "production") {echo PC_ENV;} ?></title>
</head>
<body>
  <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-transparent">
    <a class="navbar-brand" href="<?php echo PC_SITEURL; ?>/?page=home">🍀 <?php if (PC_ENV == "production") {echo "Project Clover";} else {echo PC_ENV . " " . $table_prefix;} ?></a>
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
            <a class="dropdown-item" href="./?page=mobileconfig">Install iOS app</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="javascript:alert('没错，这个链接啥功能也木有 😛')">Very Very Suspicious 👀</a>
        </li>
        <?php if (PC_ENV != "production") { ?>
        <li class="nav-item">
          <a class="nav-link" href="#"><?php echo "env: " . PC_ENV . " prefix: " . $table_prefix; ?></a>
        </li>
        <?php } ?>
      </ul>
      <?php if ( isset($_SESSION["signedin"]) && $_SESSION["signedin"] ) {
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
