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
          $i = 0;
          while ($post = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $i++;
            if ($i > 5) break;
          ?>
          <table id="feedPost_<?php echo $post["id"]; ?>" class="feed-table" tabindex="0">
            <tr>
              <th rowspan="2" class="feed-avatar">
                <img src="<?php echo loadResourceFrom('site', '/assets/img/authuser_' . $post["authuser"] . '.jpg'); ?>" title="Avatar of <?php echo currentAuthuserName($post["authuser"]); ?>" alt="Avatar of <?php echo currentAuthuserName($post["authuser"]); ?>" class="img-thumbnail rounded" width="72">
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
              <td class="feed-content-left" colspan="1"></td>
              <td title="Post Content" class="feed-content" colspan="2"><?php echo $post["content"]; ?></td>
            </tr>
            <tr>
              <td class="feed-actions" colspan="3">
                <div class="btn-group d-flex" role="group" aria-label="Post Actions">
                  <button type="button" class="btn btn-outline-primary btn-sm w-100 feed-action-like">Like</button>
                  <button type="button" class="btn btn-outline-primary btn-sm w-100 feed-action-comment" disabled>Comment</button>
                  <?php if ($post["authuser"] == $_SESSION["authuser"]) {?>
                  <button type="button" class="btn btn-outline-danger btn-sm w-100 feed-action-remove">Remove</button>
                  <?php } ?>
                </div>
              </td>
            </tr>
            <tr>
              <td class="feed-likes" colspan="3">
                <?php
                $stmt2 = $conn->prepare("SELECT * FROM $db_posts_likes WHERE id IN ( SELECT MAX(id) FROM $db_posts_likes WHERE post_id = " . $post['id'] . " GROUP BY authuser) ORDER BY created ASC");
                $stmt2->execute();
                while ($comment = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                  if ($comment["liked"] == 1) {
                    ?>
                    <span class="feed-likes-authuser-<?php echo $comment["authuser"] ?>">
                    <?php
                    echo "💙 " . currentAuthuserName($comment["authuser"]);
                    ?>
                    </span>
                    <?php
                  }
                ?>
                <?php } ?>
              </td>
            </tr>
          </table>
          <?php
          }
          $conn = null;
          ?>
          <div class="d-flex align-items-center feed-infinite-scroll">
            <strong>Loading...</strong>
            <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
          </div>
        </div>
        <div class="col-12 col-lg-3">
        </div>
      </div>
    </div>
  </section>
