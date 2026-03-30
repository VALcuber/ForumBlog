<main class="main">

    <div class="container-fluid">

        <?php if(isset($pageData['success_message'])): ?>
        <div class="alert alert-success text-center" role="alert">
            <i class="fas fa-check-circle"></i> <?= $pageData['success_message'] ?>
        </div>
        <?php endif; ?>

        <div class="row px-4 py-2 align-items-center g-0">
            <div class="col-md-8 col-lg-9 ps-4 pl-0">
                <h4 class="pt-1" style="font-size: 2.2em; font-weight: bold;">
                    <?= $pageData['category_name'] ?>
                </h4>
            </div>

            <div class="col-12 col-md-4 col-lg-3 px-0">
                <div class="d-flex align-items-center justify-content-center">
                    <button type="button" class="btn-add rounded-circle bg-secondary shadow-sm mr-3">
                        <i class="bi bi-plus text-white"></i>
                    </button>
                    <div class="ms-2">
                        <a href="/forum" class="text-uppercase mr-3">Forum</a>
                        <a href="/blog" class="text-uppercase">Blog</a>
                    </div>
                </div>
            </div>
        </div>

        <?php
            global $env;
            $showOnlyBlog = isset($env['route1']) && $env['route1'] === 'blog';
            $showOnlyForum = isset($env['route1']) && $env['route1'] === 'forum';
            $showBlogColumn = $showOnlyBlog || (!$showOnlyBlog && !$showOnlyForum);
            $showForumColumn = $showOnlyForum || (!$showOnlyBlog && !$showOnlyForum);
        ?>

        <div class="row pt-0 gx-0">

            <div class="d-flex row col-md-8 col-lg-9 ps-4 pe-0 justify-content-center">

                <?php if($showBlogColumn): ?>
                <div class="col-lg-4 d-flex">

                    <div class="card mx-2 mb-4 flex-grow-1">

                        <div class="card-header d-flex justify-content-center align-items-center">

                            <h5 class="card-title">BLOG FOR THIS CATEGORY</h5>

                        </div>

                        <div class="card-body d-flex flex-column" id="pagination-target-blog-cat"></div>

                    </div>

                </div>
                <?php endif; ?>

                <?php if($showForumColumn): ?>
                <div class="col-lg-4 d-flex">

                    <div class="card mx-2 mb-4 flex-grow-1">

                        <div class="card-header d-flex justify-content-center align-items-center">

                            <h5 class="card-title">FORUM FOR THIS CATEGORY</h5>

                        </div>

                        <div class="card-body d-flex flex-column" id="pagination-target-forum-cat"></div>

                    </div>

                </div>
                <?php endif; ?>
            </div>

            <div class="col-12 col-md-4 col-lg-3">
                <aside class="h-100">
                    <div class="right-column-content h-100">
                        <div class="card border border-dark h-100" style="border-right: none; border-radius: 0;">
                            <div class="card-body">
                                <h5 class="card-title mb-4">LATEST POSTS FROM FORUM & BLOG CATEGORYS</h5>

                                <?php if(!empty($pageData['latest_posts_list'])):
                                         foreach($pageData['latest_posts_list'] as $post): ?>
                                <li class="py-2">
                                    <a href="/<?= $pageData['current_route'] ?><?= $post['translit'] ?>">
                                        <?= $post['Category'] ?>
                                    </a>
                                </li>
                                <?php     endforeach;
                                      endif; ?>
                            </div>
                        </div>
                    </div>
                </aside>

            </div>

        </div>

    </div>

</main>