<main class="main">

    <div class="container-fluid">

        <?php if(isset($pageData['success_message'])): ?>
        <div class="alert alert-success text-center" role="alert">
            <i class="fas fa-check-circle"></i> <?= $pageData['success_message'] ?>
        </div>
        <?php endif; ?>

        <div class="row px-4 py-2 align-items-center g-0">
            <div class="col-md-8 col-lg-9 ps-4">
                <h4 class="m-0"><?= $pageData['category_name'] ?></h4>
            </div>

            <div class="col-12 col-md-4 col-lg-3 px-0">
                <div class="d-flex align-items-center justify-content-center">
                    <button type="button" class="btn-add rounded-circle bg-secondary shadow-sm mr-3">
                        <i class="bi bi-plus text-white"></i>
                    </button>
                    <div class="ms-2">
                        <a href="#" class="text-uppercase mr-3">Forum</a>
                        <a href="#" class="text-uppercase">Blog</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row py-2 gx-0">
            <div class="col-md-8 col-lg-9 ps-4 pe-0">
                <div class="subcategories-box p-3">
                    <nav>
                        <ul class="p-0 blog_topics row row-cols-3">
                            <?php if(!empty($pageData['topics_list'])): ?>
                            <?php foreach($pageData['topics_list'] as $topic): ?>
                            <li class="blog-content py-2 col d-flex justify-content-left">
                                <a href="/<?= $topic['structure'] ?>/<?= $topic['Category'] ?>/<?= $topic['translit'] ?>">
                                    <?= $topic['Description'] ?>
                                </a>
                            </li>
                            <?php endforeach;
                                  endif; ?>
                        </ul>
                    </nav>
                </div>
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

    <aside class="add-article-menu flex-column p-3">
        <button class="add-article-menu__close-btn">
            <i class="bi bi-x"></i>
        </button>
        <h4 class="text-center pt-2">ADD AN ARTICLE</h4>
        <div class="add-article-menu__navigation flex-grow-1 d-flex align-items-center justify-content-around">
            <a href="#" class="text-dark font-weight-bold">TO BLOG</a>
            <div class="add-article-menu__separator"></div>
            <a href="#" class="text-dark font-weight-bold">TO FORUM</a>
        </div>
    </aside>
</main>