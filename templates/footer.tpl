        <footer class="footer bg-secondary">

    <div class="container-fluid h-100">

        <div class="row px-4 py-2 h-100 align-items-center justify-content-between">

            <h3>Footer</h3>

            <div class="d-flex justify-content-end">
                <h5>Admin email:<?= htmlspecialchars($pageData['publick_admin_email']['contact_email']) ?></h5>
            </div>
        </div>

    </div>

</footer>

        <div id="burger-menu" class="menu d-flex">

    <nav class="navbar navbar-light bg-white menu__navigation">

        <ul class="navbar-nav flex-column">

            <li class="navbar-item py-2"><a href="/description" class="navbar-link">DESCRIPTION</a></li>

            <li class="navbar-item py-2"><a href="#" class="navbar-link">HELP</a></li>

            <li class="navbar-item py-2" id="categories-btn"><a href="/all" class="navbar-link">CATEGORIES</a></li>

        </ul>

    </nav>

    <div class="menu__separator-wrapper d-flex bg-white">

        <div class="menu__separator my-auto">

        </div>

    </div>

    <ul class="navbar-nav menu__categories bg-white p-4">

        <?= $pageData['burger']?>

    </ul>

</div> <!-- burger menu -->

        <div id="<?= $pageData['user_menu_window'] ?>" class="user-menu d-flex">

    <nav class="bg-white user-nav">

        <ul class="navbar-nav flex-column">

            <li class="navbar-item py-2"><a href="/user_profile" class="navbar-link">PROFILE</a></li>

            <li class="navbar-item py-2"><a href="#" class="navbar-link">MESSAGES</a></li>

            <li class="navbar-item py-2"><a href="#" class="navbar-link">SETTINGS</a></li>

        </ul>

        <form method="post" class="user-form">

            <input type="submit" class="btn btn-primary btn-lg" name="act" value="Exit">
        </form>

    </nav>

    <div class="menu__separator-wrapper d-flex bg-white">

        <div class="menu__separator my-auto">

        </div>

    </div>

    <ul class="navbar-nav menu__categories bg-white p-4">

        <?= $pageData['burger']?>

    </ul>

</div> <!-- User side menu -->

        <div class="modal fade" id="signinModal" tabindex="-1" aria-labelledby="signinModalLabel" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="signinModalLabel">Log In</h5>

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

                                <input type="email" name="email" class="form-control" autocomplete="username">

                            </div>

                        </div>

                        <div class="form-group row">

                            <label for="password" class="col-3 col-form-label">password</label>

                            <div class="col-9">

                                <input type="password" name="password" class="form-control" autocomplete="current-password">

                            </div>

                        </div>

                        <div class="d-flex justify-content-between">

                            <input type="submit" class="btn btn-primary btn-lg" name="act" value="Forget password">

                            <button type="button" data-toggle="modal" data-target="#registrationModal" data-dismiss="modal" class="btn btn-secondary">Registration</button>

                            <input type="submit" class="btn btn-primary btn-lg" name="act" value="Log In">

                        </div>
                        
                        <!-- Google OAuth Login Button -->
                        <div class="text-center mt-3">
                            <hr>
                            <p class="text-muted mb-2">Or sign in with</p>
                            <a href="/google-login" class="btn btn-outline-danger btn-lg">
                                <i class="fab fa-google"></i> Sign in with Google
                            </a>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

        <div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="registrationModalLabel" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="registrationModalLabel">Registration</h5>

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

                                <input type="text" id="first-name" name="first-name" class="form-control" required>

                            </div>

                        </div>

                        <div class="form-group row">

                            <label for="last-name" class="col-3 col-form-label">Last name</label>

                            <div class="col-9">

                                <input type="text" id="last-name" name="last-name" class="form-control" required>

                            </div>

                        </div>

                        <div class="form-group row">

                            <label for="birthday" class="col-3 col-form-label">birthday</label>

                            <div class="col-9">

                                <input type="date" id="birthday" name="birthday" class="form-control" required>

                            </div>

                        </div>

                        <div class="form-group row">

                            <label for="email" class="col-3 col-form-label">email</label>

                            <div class="col-9">

                                <input type="email" id="email" name="email" class="form-control"  autocomplete="username" required>

                            </div>

                        </div>

                        <div class="form-group row">

                            <label for="password" class="col-3 col-form-label">password</label>

                            <div class="col-9">

                                <input type="password" id="password" name="password" class="form-control" autocomplete="current-password" required>

                            </div>

                        </div>

                        <div class="d-flex justify-content-end">

                            <input type="submit" class="btn btn-primary" name="act" value="Register"/> <!-- data-dismiss="modal" -->

                        </div>
                        
                        <!-- Google OAuth Registration Button -->
                        <div class="text-center mt-3">
                            <hr>
                            <p class="text-muted mb-2">Or register with</p>
                            <a href="/google-login" class="btn btn-outline-danger btn-lg">
                                <i class="fab fa-google"></i> Sign up with Google
                            </a>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

        <div class="modal fade" id="forum_blog_formModal" tabindex="-1" aria-labelledby="forum_blog_formModalLabel" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

        <div class="modal-header">

            <h5 class="modal-title" id="forum_blog_formModalLabel">Form for adding content to Forum</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                <span aria-hidden="true">&times;</span>

            </button>

        </div>

        <div class="modal-body">

            <div class="container-fluid">

                <form method="post">
<!--
                    <div class="form-group row">

                        <label for="first-name" class="col-3 col-form-label">Where</label>

                        <div class="col-9">

                            <select name="where">
                                <option value="Forum">Форум</option>
                                <option value="Blog">Блог</option>
                            </select>

                        </div>

                    </div>
-->
                    <div class="form-group row">

                        <label for="first-name" class="col-3 col-form-label">Topic</label>

                        <div class="col-9">

                            <input type="text" name="Topic" class="form-control">

                        </div>

                    </div>

                    <div class="form-group row">

                        <label for="last-name" class="col-3 col-form-label">Title</label>

                        <div class="col-9">

                            <input type="text" name="Title" class="form-control">

                        </div>

                    </div>

                    <div class="form-group row">

                        <label for="birthday" class="col-3 col-form-label">description</label>

                        <div class="col-9">

                            <input type="text" name="description" class="form-control description">

                        </div>

                    </div>

                    <div class="d-flex justify-content-end">

                        <input type="submit" class="btn btn-primary" name="act" value="Post"/> <!-- data-dismiss="modal" -->

                    </div>

                </form>

            </div>

        </div>

    </div>

    </div>

</div> <!-- Form for adding content -->
        <form id="hiddenPostForm" method="POST" style="display: none;">
            <input type="hidden" name="token" value="<?= htmlspecialchars($pageData['id_login']) ?>">
        </form> <!-- Token form -->

        <script src="/assets/js/livesearch.js"></script>
        <?= $pageData['script_page_all'] ?>
    </body>

</html>