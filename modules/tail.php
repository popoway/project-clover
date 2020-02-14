  <footer id="tail" style="padding-top: 56px;">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-3">
        </div>
        <div class="col-12 col-lg-6 text-center">
          <p>
            <sub>
              &copy; <?php echo date("Y"); ?> popoway. <a href="https://github.com/popoway/project-clover" target="_blank">GitHub</a><br>
              Debug info: Running on <?php echo $site_url; ?> in <?php echo $development_mode; ?> mode. SQLite <?php echo getSqliteVersion(); ?>
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
</body>
</html>
