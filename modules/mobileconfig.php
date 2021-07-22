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
          <p>点击下方安装按钮以添加 Project Clover 到您的主屏幕。</p>
          <button type="button" class="btn btn-primary" onclick="window.location.href = '<?php echo PC_SITEURL; ?>/assets/mobileconfig/clover_shortcut_signed.mobileconfig?ver=<?php echo PC_VER; ?>'">安装</button>
          <?php
          }
          ?>
        </div>
        <div class="col-12 col-lg-3">
        </div>
      </div>
    </div>
  </section>
