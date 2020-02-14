  <section id="main">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-3">
        </div>
        <div class="col-12 col-lg-6">
          <form id="mainForm" action="<?php echo $site_url; ?>/modules/feedUpload.php" method="post">
            <div class="form-group">
              <label for="mainInput">
                <span id="mainFormName"><?php echo currentAuthuserName($authuser); ?></span><span>, What do you want to say today?</span>
              </label>
              <textarea class="form-control" id="mainInput" name="mainInput" rows="3" aria-describedby="mainInputHelp" autofocus></textarea>
              <small id="mainInputHelp" class="form-text text-muted">随便说点什么吧～😉</small>
            </div>
            <input type="hidden" id="authuser" name="authuser" value="<?php echo $authuser; ?>">
            <button type="submit" class="btn btn-primary">发表</button>
          </form>
        </div>
        <div class="col-12 col-lg-3">
        </div>
      </div>
    </div>
  </section>
