
  <main class="main">

    <div class="container-fluid wrapper bg-white">

      <div class="row">

        <div class="col-lg-4 d-flex">

          <div class="card mx-2 mb-4 flex-grow-1">

            <div class="card-header d-flex justify-content-between align-items-center">

              <h5 class="card-title">BLOG</h5>

              <a href="/blog" class="card-link">Go to Blog</a>

            </div>

            <div class="card-body d-flex flex-column">

              <?= $pageData['blog'] ?>

            </div>

          </div>

        </div>

        <div class="col-lg-4 d-flex">

          <div class="card mx-2 mb-4 flex-grow-1">

            <div class="card-header d-flex justify-content-between align-items-center">

              <h5 class="card-title">NEWS</h5>

              <a href="/news" class="card-link">Go to News</a>

            </div>

            <div class="card-body d-flex-1 flex-column">

                <?= $pageData['news'] ?>

            </div>

          </div>

        </div>

        <div class="col-lg-4 d-flex">

          <div class="card mx-2 mb-4 flex-grow-1">

            <div class="card-header d-flex justify-content-between align-items-center">

              <h5 class="card-title">FORUM</h5>

              <a href="/forum" class="card-link">Go to Forum</a>

            </div>

            <div class="card-body d-flex flex-column">

              <?= $pageData['forum'] ?>

            </div>

          </div>

        </div>

      </div>

    </div>

  </main>
