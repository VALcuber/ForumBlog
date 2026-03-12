        <div id="burger-menu" class="menu d-flex">

            <nav class="navbar navbar-light bg-white menu__navigation">

                <ul class="navbar-nav flex-column">

                    <li class="navbar-item py-2"><a href="/description" class="navbar-link">DESCRIPTION</a></li>

                    <li class="navbar-item py-2"><a href="/help" class="navbar-link">HELP</a></li>

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

                    <li class="navbar-item py-2"><a href="/user_profile/messages" class="navbar-link">MESSAGES</a></li>

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

                        <h5 class="modal-title" id="forum_blog_formModalLabel">
                            <span id="modal-type-text"></span>
                        </h5>

                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                    <div class="modal-body">

                        <div class="container-fluid">

                            <form method="post">

                                <div class="form-group row">
                                    <label for="category-select" class="col-3 col-form-label">Category</label>
                                    <div class="col-9">
                                        <select id="category-select" class="form-control mb-2">
                                            <option value="" data-desc="">-- Create new category --</option>

                                            <?php if(!empty($pageData['blog_categories'])): ?>
                                            <?php foreach($pageData['blog_categories'] as $cat): ?>
                                            <option value="<?= htmlspecialchars($cat['Category']) ?>" data-type="blog" data-desc="<?= htmlspecialchars($cat['Category_Description']) ?>" class="cat-option">
                                                <?= htmlspecialchars($cat['Category']) ?>
                                            </option>
                                            <?php endforeach; ?>
                                            <?php endif; ?>

                                            <?php if(!empty($pageData['forum_categories'])): ?>
                                            <?php foreach($pageData['forum_categories'] as $cat): ?>
                                            <option value="<?= htmlspecialchars($cat['Category']) ?>" data-type="forum" data-desc="<?= htmlspecialchars($cat['Category_Description']) ?>" class="cat-option">
                                                <?= htmlspecialchars($cat['Category']) ?>
                                            </option>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>

                                        <input type="text" autocomplete="off" name="Category" id="category-input" class="form-control" placeholder="Enter new category name...">

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="category-desc-input" class="col-3 col-form-label">Category Description</label>
                                    <div class="col-9">
                                        <input type="text" autocomplete="off" id="category-desc-input" name="Category_Description" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="subcategory-input" class="col-3 col-form-label">Subcategory</label>
                                    <div class="col-9">
                                        <input type="text" autocomplete="off" id="subcategory-input" name="Subcategory" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="description-input" class="col-3 col-form-label">Description</label>
                                    <div class="col-9">
                                        <input type="text" autocomplete="off" id="description-input" name="Description" class="form-control description">
                                    </div>
                                </div>

                                <input type="hidden" name="target" id="modal-act-input" value="">

                                <div class="d-flex justify-content-end">
                                    <input type="submit" class="btn btn-primary" name="act" value="Post"/>
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

        <aside class="add-article-menu flex-column p-3">
            <button class="add-article-menu__close-btn">
                <i class="bi bi-x"></i>
            </button>
            <h4 class="text-center pt-2">ADD AN ARTICLE</h4>

            <div class="add-article-menu__navigation flex-grow-1 d-flex align-items-center justify-content-around">
                <div class="d-flex w-100 align-items-center justify-content-around">
                    <button type="button"
                            class="custom-menu-btn text-dark font-weight-bold"
                            data-toggle="modal"
                            data-target="#forum_blog_formModal"
                            data-title="Form for adding content to BLOG"
                            data-type="Blog"
                            data-act="blog">
                        TO BLOG
                    </button>

                    <div class="add-article-menu__separator"></div>

                    <button type="button"
                            class="custom-menu-btn text-dark font-weight-bold"
                            data-toggle="modal"
                            data-target="#forum_blog_formModal"
                            data-title="Form for adding content to FORUM"
                            data-type="Forum"
                            data-act="forum">
                        TO FORUM
                    </button>
                </div>
            </div>
        </aside> <!-- Choose buttons popup window  -->

        <footer class="footer bg-secondary">

            <div class="container-fluid h-100">

                <div class="row px-4 py-2 h-100 align-items-center justify-content-between">

                    <h3>Footer</h3>

                    <div class="d-flex justify-content-end">
                        <h5>Admin email:<?= htmlspecialchars($pageData['publick_admin_email']['contact_email']) ?></h5>
                    </div>
                </div>

            </div>

            <script src="/assets/js/livesearch.js"></script>

            <script src="/assets/js/index.js"></script>

            <?= $pageData['script_page_all'] ?>
            <?= $pageData['script_category'] ?>
            <?= $pageData['script_profile'] ?>
            <?= $pageData['script_conversation'] ?>
            <?= $pageData['script_page_pagination'] ?>

        </footer>
    </body>


</html>