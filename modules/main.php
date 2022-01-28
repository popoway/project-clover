  <section id="main">
    <?php
    $t = $_SERVER['HTTP_USER_AGENT'];
    if (strpos($t, 'Mac OS X') && strpos($t, 'iPhone OS') && !strpos($t, 'MicroMessenger') && !strpos($t, 'Chrome') && !strpos($t, 'CriOS')) {
    ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      <strong>Add Project Clover to Home Screen!</strong> For easier access. Simply tap Share button below (iPhone) or above (iPad). <a href="/?page=mobileconfig" class="alert-link">Read me</a> for more information.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <?php
    }
    ?>
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-3">
        </div>
        <div class="col-12 col-lg-6">
          <form id="mainForm" novalidate>
            <div class="form-group">
              <label for="mainInput">
                <span id="mainFormName"><?php echo currentAuthuserName($authuser); ?></span><span>, What do you want to say today?</span>
              </label>
              <textarea class="form-control" id="mainInput" name="mainInput" rows="3" placeholder="Say something..." aria-describedby="mainInputHelp" autofocus required></textarea>
              <div class="invalid-feedback">Callback Error message</div>
              <small id="mainInputHelp" class="form-text text-muted">随便说点什么吧～😉</small>
            </div>
            <input type="hidden" id="authuser" name="authuser" value="<?php echo $authuser; ?>">
            <button type="submit" class="btn btn-primary" id="mainFormButtonSubmit">发表</button>
            <button type="reset" class="btn btn-secondary" id="mainFormButtonReset" onclick="wordCountOnReset()">清空</button>
          </form>
        </div>
        <div class="col-12 col-lg-3">
        </div>
      </div>
    </div>
  </section>
