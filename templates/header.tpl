<body>

    <?= $pageData['panel']?>

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

                <img src="<?= $pageData['slash'] ?>assets/img/logo.png" alt="logo img">

            </a>

            <div class="header__column d-flex align-items-center justify-content-end">

                <input type="text" class="header__search px-3 mr-sm-4 border-0 rounded-pill d-block" placeholder="Search...">

                <button data-state = "closed" class="toggle-btns header__profile text-center d-none d-sm-block rounded-circle" <?= $pageData['signin_modal_winwow'] ?> > <?= $pageData['check'] ?> </button>

            </div>

        </div>
        <div class="modal" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title" id="userModalLabel">Log In</h5>

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

                                    <input type="submit" class="btn btn-primary btn-lg" name="act" value="Forget password">

                                    <button type="button" data-toggle="modal" data-target="#registrationModal" data-dismiss="modal" class="btn btn-secondary">Registration</button>

                                    <input type="submit" class="btn btn-primary btn-lg" name="act" value="Log In">

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>
        <div class="row px-4 py-4">

            <nav class="categories flex-grow-1" id="categories">

                <ul class="nav nav-pills nav-fill flex-nowrap" id="categories-list">
                    <?= $pageData['topmenu']?>

    </div>

</header>
