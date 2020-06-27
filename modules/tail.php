  <footer id="tail" style="padding-top: 56px;">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-3">
        </div>
        <div class="col-12 col-lg-6 text-center">
          <p>
            <sub>
              project-clover v<?php echo CVER; ?> &copy; <?php echo date("Y"); ?> popoway. <a href="https://github.com/popoway/project-clover" target="_blank">GitHub</a>
              <a href="javascript:alert('Debug info: \nRunning on <?php echo gethostname(); ?> in <?php echo $development_mode; ?> mode. \nSite URL: <?php echo $site_url; ?>\nSQLite: <?php echo getSqliteVersion(); ?> \nServer timestamp: <?php echo(date("Y-m-d h:m:s T+Z")); ?>')">Debug</a>
              <a href="https://www.popoway.cloud/portal/" target="_blank">Status</a>
            </sub>
          </p>
        </div>
        <div class="col-12 col-lg-3">
        </div>
      </div>
    </div>
  </footer>

  <script src="<?php echo $cdn_url; ?>/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="<?php echo $cdn_url; ?>/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="<?php echo $site_url; ?>/assets/js/main.js?ver=<?php echo CVER; ?>"></script>
</body>
</html>
