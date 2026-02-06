<main class="main">
  <div class="container-fluid wrapper bg-white">
    <div class="row px-4">
      <section class="col-lg-10 col-md-12 mx-auto my-2">

        <div class="card">
          <div class="card-header">
            <h2 class="text-center p-2"><?= $pageData['title']; ?></h2>
          </div>
          <div class="card-body">
            <p class="p-2"><?= $pageData['content']; ?></p>
            <p class="p-1 text-right">by <?= $pageData['nickname']; ?></p>
          </div>
        </div>

        <?php global $env; if ($env['route1'] == 'blog' || $env['route1'] == 'forum'): ?>
        <div>
          <ul id="messages" class="row px-5 message list-unstyled"></ul>
          <div id="pagination" class="d-flex justify-content-center my-4"></div>
        </div>
        <div class="row px-4">
          <form id="comments-send" class="row gy-2 gx-3 align-items-center col-lg-10 col-md-12 mx-auto my-2" method="post">
            <div class="col-10">
              <input type="text" id="comment_text" class="form-control" name="forum_commit" required>
            </div>
            <div class="col-2 text-center">
              <input type="submit" name="act" class="btn btn-primary" value="Commit">
            </div>
          </form>
        </div>

        <?php endif; ?>

      </section>
    </div>
  </div>
  <?= $pageData['forum_comments']; ?>
</main>