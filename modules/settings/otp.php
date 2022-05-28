  <section id="settingsOtp">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-3">
        </div>
        <div class="col-12 col-lg-6">
          <h1>Multi-factor Authentication Settings</h1>
          <p>To set up MFA, simply refer to the following steps:</p>
          <ol>
            <li>Install <a href="https://apps.apple.com/us/app/bark-customed-notifications/id1403753865" target="_blank">Bark</a> on your iOS device.</li>
            <li>Open Bark app, tap the cloud icon on top right corner. Server List should appear. Tap the first item in Server List.</li>
            <li>Tap "Copy address and key" and paste the link into the textbox below.</li>
            <li>To verify that MFA is properly configured, click "Send Code". Your iOS device will receive an one-time code. Type the code below.</li>
            <li>Click "Complete" to finish setup.</li>
          </ol>
          <form id="changePassword" novalidate>
            <div class="form-group row">
              <label for="addressAndKey" class="sr-only">Address and key</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="addressAndKey" placeholder="https://address.com/key">
              </div>
              <div class="col-sm-4">
                <button type="button" class="btn btn-primary">Send code</button>
              </div>
            </div>
            <div class="form-group">
              <label for="otpCode">One Time Code</label>
              <input type="text" class="form-control" id="otpCode" placeholder="123456" inputmode="numeric" pattern="[0-9]*" autocomplete="one-time-code">
            </div>
            <button type="submit" class="btn btn-primary">Complete</button>
          </form>
          <p>To disable MFA (not recommended), leave the "Address and key" textbox blank and click Complete.</p>
        </div>
        <div class="col-12 col-lg-3">
        </div>
      </div>
    </div>
  </section>
