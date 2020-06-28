  <section id="signin">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-3">
        </div>
        <div class="col-12 col-lg-6 text-center">
          <h1>Sign in to Project Clover</h1>
          <div class="signin-avatar-picker">
            <div class="signin-avatar-picker-choice" tabindex="0">
              <img src="<?php echo $site_url; ?>/assets/img/authuser_0.jpg?ver=<?php echo CVER; ?>" title="Avatar of Yeshan" alt="Avatar of Yeshan" class="img-thumbnail rounded" width="72">
              <span>Yeshan</span>
            </div>
            <div class="signin-avatar-picker-choice" tabindex="0">
              <img src="<?php echo $site_url; ?>/assets/img/authuser_1.jpg?ver=<?php echo CVER; ?>" title="Avatar of Ming" alt="Avatar of Ming" class="img-thumbnail rounded" width="72">
              <span>Ming</span>
            </div>
          </div>
          <form id="signinPassword" novalidate>
            <input type="hidden" id="signinInputAuthuser" name="authuser" value="4869">
            <div class="form-group">
              <label class="sr-only" for="signinInputPassword">Password</label>
              <input type="password" class="form-control" id="signinInputPassword" name="password" placeholder="Password 🔑" required>
              <div class="invalid-feedback">Callback Error message</div>
            </div>
            <button type="submit" class="btn btn-primary">Sign in</button>
            <button type="reset" class="btn btn-secondary" onclick="window.location.reload();">Cancel</button>
          </form>
        </div>
        <div class="col-12 col-lg-3">
        </div>
      </div>
    </div>
  </section>
