<?php
# Open the database connection
$db = new SQLite3($sqlite3_filename, SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
?>

  <section id="feed">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-3">
        </div>
        <div class="col-12 col-lg-6">
          <h2>Our Feed 我们的动态</h2>
          <?php
          $statement = $db->prepare('SELECT * FROM "posts" WHERE id NOT IN (SELECT post_id FROM posts_hidden) ORDER BY "created" DESC');
          $result = $statement->execute();
          while ($post = $result->fetchArray(SQLITE3_ASSOC)) {
          ?>
          <table id="feedPost_<?php echo $post["id"]; ?>" class="feed-table" tabindex="0">
            <tr>
              <th rowspan="2" class="feed-avatar">
                <img src="<?php echo $site_url; ?>/assets/img/authuser_<?php echo $post["authuser"]; ?>.jpg?ver=<?php echo CVER; ?>" title="Avatar of <?php echo currentAuthuserName($post["authuser"]); ?>" alt="Avatar of <?php echo currentAuthuserName($post["authuser"]); ?>" class="img-thumbnail rounded" width="72">
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
          // Free the memory, this is NOT done automatically, while the script is running
          $result->finalize();
          // Close the database.
          $db->close();
          ?>
        </div>
        <div class="col-12 col-lg-3">
        </div>
      </div>
    </div>
  </section>
