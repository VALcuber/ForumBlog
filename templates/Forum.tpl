
<main class="main">

    <div class="container-fluid">

        <div class="row px-4 py-2">

            <div class="col-8 px-0 forum">

                <?=$pageData['forum_titles']?>

            </div>

            <div class="col-4">

                <aside>

                    <div class="card border border-dark">

                        <div class="card-body">

                            <h5 class="card-title mb-4">RECENT FORUM NEWS</h5>

                            <h5 class="card-title">Interface</h5>

                            <p class="card-text">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Expedita rerum voluptatibus dignissimos asperiores sapiente, quo dolorum inventore fugiat commodi dicta.</p>

                            <h5 class="card-title">UX</h5>

                            <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae veniam unde velit sunt, assumenda esse magni ab veritatis vel doloribus?</p>

                            <h5 class="card-title">UI</h5>

                            <p class="card-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Fugit alias omnis optio animi magnam illo ipsum obcaecati tenetur quidem sunt.</p>

                            <h5 class="card-title">Interface</h5>

                            <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere consequuntur error dolore sapiente distinctio nostrum voluptas praesentium dicta facilis repellendus.</p>

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

            <a href="/forum" data-toggle="modal" data-target="#forum_blog_formModal" class="text-dark font-weight-bold">TO FORUM</a>

            <div class="add-article-menu__separator"></div>

            <a href="/blog" data-toggle="modal" data-target="#forum_blog_formModal" class="text-dark font-weight-bold">TO BLOG</a>

        </div>

    </aside>
</main>