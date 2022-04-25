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
