<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="shortcut icon" href="../assets/img/icon.svg" type="image/x-icon">
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

  <title>Wrong Login</title>

</head>

<body>

  <div class="container">

    <div class="row d-flex justify-content-center">

      <div class="col-6">

        <div class="card my-4">

          <h5 class="card-header">Login</h5>

          <div class="card-body">

            <form method="POST">

              <div class="form-group row">

                <label for="email" class="col-3 col-form-label font-weight-bold">email</label>

                <div class="col-9">

                  <input type="email" name="email" id="email" class="form-control <?=$pageData['wrong']?>" required>

                </div>

              </div>

              <div class="form-group row">

                <label for="password" class="col-form-label col-3 font-weight-bold">password</label>

                <div class="col-9">

                  <input type="password" name="password" id="password" class="form-control <?=$pageData['wrong']?>">

                  <div class="invalid-feedback">

                    Your email or password is incorrent

                  </div>

                </div>

              </div>

              <div class="d-flex justify-content-end">

                <button type="button" class="btn btn-secondary mr-4">Registration</button>

                <input type="submit" class="btn btn-primary" name="act" value="Login"/>

              </div>

            </form>

          </div>

        </div>

      </div>

    </div>

  </div>

</body>

</html>