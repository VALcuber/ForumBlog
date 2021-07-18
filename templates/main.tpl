<body>

  <header class="header">

    <div class="container-fluid bg-white wrapper">

      <div class="row px-4 py-2">

        <div class="header__column d-flex align-items-center">

          <button data-state = "closed" class="toggle-btn bg-transparent border-0">

            <span class="toggle-btn__bar my-2"></span>

            <span class="toggle-btn__bar my-2"></span>

            <span class="toggle-btn__bar my-2"></span>

          </button>

        </div>

        <a href="/" class="header__logo mx-3">

          <img src="assets/img/logo.png" alt="logo img">

        </a>

        <div class="header__column d-flex align-items-center justify-content-end">

          	<?= $pageData['panel']?>

			<input type="text" class="header__search px-3 mr-sm-4 border-0 rounded-pill d-block" placeholder="Search...">

          <a href="#" class="header__profile text-center d-none d-sm-block rounded-circle" data-toggle="modal" data-target="#signinModal"><?= $pageData['check'] ?></a>

        </div>

      </div>

      <div class="row px-4 py-4">

        <nav class="categories flex-grow-1" id="categories">

          <ul class="nav nav-pills nav-fill flex-nowrap" id="categories-list">

            <li class="nav-item ">

              <a href="/" class="nav-link <?=$pageData['active']?> categories__link text-nowrap">Home</a>

            </li>

            <?= $pageData['topmenu']?>

          </ul>

        </nav>

      </div>

    </div>

  </header>

  <div class="modal fade" id="signinModal" tabindex="-1" aria-labelledby="registrationModalLabel" aria-hidden="true">

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header">

          <h5 class="modal-title" id="registrationModalLabel">Sign In</h5>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">&times;</span>

          </button>

        </div>

        <div class="modal-body">

          <div class="container-fluid">

            <form method="post">

              <div class="form-group row">

                <label for="email" class="col-3 col-form-label">email</label>

                <div class="col-9">

                  <input type="email" name="email" class="form-control">

                </div>

              </div>

              <div class="form-group row">

                <label for="password" class="col-3 col-form-label">password</label>

                <div class="col-9">

                  <input type="password" name="password" class="form-control">

                </div>

              </div>

              <div class="d-flex justify-content-between">

                <input type="submit" class="btn btn-primary btn-lg" name="act" value="Exit">

                <button type="button" class="btn btn-secondary">Registration</button>

                <input type="submit" class="btn btn-primary" name="act" value="Login"/>

              </div>

            </form>

          </div>

        </div>

      </div>

    </div>

  </div>

  <div class="modal fade" id="registrationModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header">

          <h5 class="modal-title" id="exampleModalLabel">Registration</h5>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">&times;</span>

          </button>

        </div>

        <div class="modal-body">

          <div class="container-fluid">

            <form method="post">

              <div class="form-group row">

                <label for="first-name" class="col-3 col-form-label">First name</label>

                <div class="col-9">

                  <input type="text" name="first-name" class="form-control" required>

                </div>

              </div>

              <div class="form-group row">

                <label for="last-name" class="col-3 col-form-label">Last name</label>

                <div class="col-9">

                  <input type="text" name="last-name" class="form-control" required>

                </div>

              </div>

              <div class="form-group row">

                <label for="birthday" class="col-3 col-form-label">birthday</label>

                <div class="col-9">

                  <input type="date" name="birthday" class="form-control" required>

                </div>

              </div>

              <div class="form-group row">

                <label for="email" class="col-3 col-form-label">email</label>

                <div class="col-9">

                  <input type="email" name="email" class="form-control" required>

                </div>

              </div>

              <div class="form-group row">

                <label for="password" class="col-3 col-form-label">password</label>

                <div class="col-9">

                  <input type="password" name="password" class="form-control" required>

                </div>

              </div>

              <div class="d-flex justify-content-end">

                <button type="button" class="btn btn-secondary mr-4">Sign In</button>

                <input type="submit" class="btn btn-primary" name="act" value="Register"/>

              </div>

            </form>

          </div>

        </div>

      </div>

    </div>

  </div>

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
