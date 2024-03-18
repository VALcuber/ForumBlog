
  <main class="main">

    <div class="container-fluid wrapper bg-white">

      <div class="row px-4">

        <section class="col-lg-10 col-md-12 mx-auto my-2">

			<?= $pageData['page'] ?>

        </section>

      </div>

      <div class="row px-5">
        <?= $pageData['comments'] ?>
      </div>

      <div class="row px-4">

        <form method="post" class="row gy-2 gx-3 align-items-center col-lg-10 col-md-12 mx-auto my-2">

          <div class="col-10">

            <textarea class="form-control" name="forum_commit"></textarea>

          </div>

          <div class="col-1.5">

            <input type="submit" class="btn btn-primary btn-lg" name="act" value="Commit">

          </div>

        </form>

      </div>

    </div>

  </main>
