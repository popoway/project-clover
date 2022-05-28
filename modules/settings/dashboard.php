  <section id="settingsDashboard">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-3">
        </div>
        <div class="col-12 col-lg-6">
          <h1>Settings</h1>
          <p>Here you can take a glance at your account and settings. 😉</p>
          <h2>Change Password</h2>
          <p>Note: All currently-signed-in devices (including this one) will be signed out of Project Clover.</p>
          <form id="changePassword" novalidate>
            <div class="form-group row">
              <label for="username" class="col-sm-4 col-form-label">Username</label>
              <div class="col-sm-8">
                <input type="text" readonly class="form-control-plaintext" id="username" value="<?php echo currentAuthuserName($_SESSION["authuser"]); ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="currentPassword" class="col-sm-4 col-form-label">Current Password</label>
              <div class="col-sm-8">
                <input type="password" class="form-control" id="currentPassword" autocomplete="current-password" required>
                <div class="invalid-feedback"></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="newPassword" class="col-sm-4 col-form-label">New Password</label>
              <div class="col-sm-8">
                <input type="password" class="form-control" id="newPassword" autocomplete="new-password" required>
                <div class="invalid-feedback"></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="confirmPassword" class="col-sm-4 col-form-label">Confirm Password</label>
              <div class="col-sm-8">
                <input type="password" class="form-control" id="confirmPassword" autocomplete="new-password" required>
                <div class="invalid-feedback"></div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Change Password</button>
          </form>
          <h2>Multi-factor Authentication</h2>
          <p>For higher security, enable MFA using the following button:</p>
          <button type="button" class="btn btn-primary" onclick="window.location.href='/?page=settings-otp'">MFA Settings</button>
        </div>
        <div class="col-12 col-lg-3">
        </div>
      </div>
    </div>
  </section>
