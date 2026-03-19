<main class="main">
    <div class="container-fluid">

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
                        <a href="/forum" class="text-uppercase mr-3">Forum</a>
                        <a href="/blog" class="text-uppercase">Blog</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row py-2 gx-0">
            <div class="col-md-8 col-lg-9 ps-4 pe-0">
                <div class="subcategories-box p-3">
                    <nav>
                        <ul class="category-list p-0 m-0">
                            <?php if (!empty($pageData['subcategories'])): ?>
                                <?php foreach ($pageData['subcategories'] as $item): ?>
                                    <li class="py-2">
                                        <a href="/<?= $item['structure'] ?>/<?= $item['Category'] ?>/<?= $item['Subcategory'] ?>/<?= $item['Description'] ?>">
                                            <?= $item['Description'] ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>

            <div class="col-12 col-md-4 col-lg-3">
                <aside class="h-100">
                    <div class="right-column-content h-100">
                        <div class="card border border-dark h-100" style="border-right: none; border-radius: 0;">
                            <div class="card-body">
                                <h5 class="d-flex card-title mb-4 justify-content-center text-center">RECENT NEWS BY THIS CATEGORY</h5>
                                <h5 class="card-title">Interface</h5>
                                <p class="card-text small">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Expedita rerum voluptatibus dignissimos asperiores sapiente, quo dolorum inventore fugiat commodi dicta.</p>
                                <h5 class="card-title">UX</h5>
                                <p class="card-text small">Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae veniam unde velit sunt, assumenda esse magni ab veritatis vel doloribus?</p>
                                <h5 class="card-title">UI</h5>
                                <p class="card-text small">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Fugit alias omnis optio animi magnam illo ipsum obcaecati tenetur quidem sunt.</p>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>

    </div>
</main>