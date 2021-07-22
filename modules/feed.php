<?php
# Open the database connection
require(__DIR__."/../api/index.php");
?>

  <section id="feed">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-3">
        </div>
        <div class="col-12 col-lg-6">
          <h2>Our Feed 我们的动态</h2>
          <?php
          $stmt = $conn->prepare("SELECT * FROM $db_posts WHERE id NOT IN (SELECT post_id FROM $db_posts_hidden) ORDER BY created DESC");
          $stmt->execute();
          while ($post = $stmt->fetch(PDO::FETCH_ASSOC)) {
          ?>
          <table id="feedPost_<?php echo $post["id"]; ?>" class="feed-table" tabindex="0">
            <tr>
              <th rowspan="2" class="feed-avatar">
                <img src="<?php echo PC_SITEURL; ?>/assets/img/authuser_<?php echo $post["authuser"]; ?>.jpg?ver=<?php echo PC_VER; ?>" title="Avatar of <?php echo currentAuthuserName($post["authuser"]); ?>" alt="Avatar of <?php echo currentAuthuserName($post["authuser"]); ?>" class="img-thumbnail rounded" width="72">
              </th>
              <th><h3 class="feed-username" title="Post sent by <?php echo currentAuthuserName($post["authuser"]); ?>"><?php echo currentAuthuserName($post["authuser"]); ?></h3></th>
            </tr>
            <tr>
              <?php
              # Explicitly define UTC datetime
              $isoDate = date_create($post["created"], timezone_open('UTC'));
              $isoDateString = date_format($isoDate, "c");
              ?>
              <td title="Post composed on <?php echo $isoDateString; ?>" class="feed-date"><?php echo $isoDateString; ?></td>
            </tr>
            <tr>
              <td class="feed-content-left"></td>
              <td title="Post Content" class="feed-content"><?php echo $post["content"]; ?></td>
            </tr>
            <tr>
              <td colspan="2" class="feed-actions">
                <button type="button" class="btn btn-primary btn-sm" disabled>Like</button>
                <button type="button" class="btn btn-primary btn-sm" disabled>Comment</button>
                <?php if ($post["authuser"] == $_SESSION["authuser"]) {?>
                <button type="button" class="btn btn-danger btn-sm feed-action-remove">Remove</button>
                <?php } else {?>
                <button type="button" class="btn btn-danger btn-sm feed-action-remove" disabled>Remove</button>
                <?php } ?>
              </td>
            </tr>
          </table>
          <?php
          }
          $conn = null;
          ?>
        </div>
        <div class="col-12 col-lg-3">
        </div>
      </div>
    </div>
  </section>
