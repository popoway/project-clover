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
          <a class="nav-link" href="#">Featured Posts</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Very Very Suspicious 👀</a>
        </li>
      </ul>
      <span class="navbar-text">
        Login | Register
      </span>
    </div>
  </nav>

  <section id="main" style="padding-top: 56px;">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-3">
        </div>
        <div class="col-12 col-lg-6">
          <h1>Hello, world!</h1>
        </div>
        <div class="col-12 col-lg-3">
        </div>
      </div>
    </div>
  </section>

  <footer id="main" style="padding-top: 56px;">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-3">
        </div>
        <div class="col-12 col-lg-6 text-center">
          <p>&copy; <?php echo date("Y"); ?> popoway. Powered by popowayCloud. <a href="https://github.com/popoway/project-clover" target="_blank">GitHub</a></p>
        </div>
        <div class="col-12 col-lg-3">
        </div>
      </div>
    </div>
  </footer>

  <script src="<?php echo $cdn_url; ?>/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="<?php echo $cdn_url; ?>/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
