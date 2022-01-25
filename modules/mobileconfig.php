  <section id="mobileconfig">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-3">
        </div>
        <div class="col-12 col-lg-6">
          <h1>Shortcut to Project Clover</h1>
          <?php
          $t = $_SERVER['HTTP_USER_AGENT'];
          if (strpos($t, 'MicroMessenger')) {
          ?>
          <p>检测到您使用的是微信客户端，请点击右上角“…”然后选择”在 Safari 中打开”。</p>
          <?php
          }
          elseif (strpos($t, 'Windows')) {
          ?>
          <p>检测到您使用的是 Windows 系统，请在 iOS 系统中打开此页面。</p>
          <?php
          }
          elseif (strpos($t, 'Mac OS X') && !strpos($t, 'iPhone OS')) {
          ?>
          <p>检测到您使用的是 macOS 系统，请在 iOS 系统中打开此页面。</p>
          <?php
          }
          elseif (strpos($t, 'Android')) {
          ?>
          <p>检测到您使用的是 Android 系统，请在 iOS 系统中打开此页面。</p>
          <?php
          }
          elseif (strpos($t, 'Chrome') || strpos($t, 'CriOS')) {
          ?>
          <p>检测到您使用的是 Chrome 浏览器，请在 iOS 中的 Safari 浏览器中打开此页面。</p>
          <?php
          }
          else {
          ?>
          <p>To install Project Clover to your Home Screen, follow the steps below:</p>
          <ol>
            <li>Tap the Share button in Safari on your screen</li>
            <li>Tap "Add to Home Screen"</li>
            <li>Tap "Add"</li>
            <li>You can now access Project Clover on your Home Screen without opening Safari.</li>
          </ol>
          <?php
          }
          ?>
        </div>
        <div class="col-12 col-lg-3">
        </div>
      </div>
    </div>
  </section>
