
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

                  <input type="email" name="email" class="form-control" required>

                </div>

              </div>

              <div class="form-group row">

                <label for="password" class="col-3 col-form-label">password</label>

                <div class="col-9">

                  <input type="password" name="password" class="form-control" required>

                </div>

              </div>

              <div class="d-flex justify-content-between">
                <form method="post>">

                  <input type="submit" class="btn btn-primary btn-lg" name="act" value="Exit">

                  <button type="button" class="btn btn-secondary mr-4">Registration</button>

                  <button type="submit" class="btn btn-primary">Login</button>
                </form>

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

            <form action="index.php" method="post">

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

                <button type="submit" class="btn btn-primary">Register</button>

              </div>

            </form>

          </div>

        </div>

      </div>

    </div>

  </div>

  <main class="main">

    <div class="container-fluid wrapper bg-white">

      <div class="row px-4">

        <section class="col-lg-10 col-md-12 mx-auto my-2">

          <?= $pageData['page'] ?>

        </section>

      </div>

    </div>
  </main>
