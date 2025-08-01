
<main class="main">

    <div class="container-fluid">

        <!-- Success message -->
        <?php if(isset($pageData['success_message'])): ?>
            <div class="alert alert-success text-center" role="alert">
                <i class="fas fa-check-circle"></i> <?= $pageData['success_message'] ?>
            </div>
        <?php endif; ?>

        <div class="row px-4 py-2">

            <div class="col-10 px-0 forum">

                <?=$pageData['forum_titles']?>

            </div>

            <div class="col-2 card-category">

                <aside>

                    <div class="card border border-dark">

                        <div class="card-body">

                            <h5 class="card-title mb-4">LATEST POSTS FROM FORUM & BLOG CATEGORYS</h5>
                            <?=$pageData['echo_latest_forum_posts']?>
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
<?php if(isset($pageData['clear_url_script'])): ?>
    <?= $pageData['clear_url_script'] ?>
<?php endif; ?>

<script>
// Automatically hide success message after 3 seconds
document.addEventListener('DOMContentLoaded', function() {
    const successMessage = document.querySelector('.alert-success');
    if (successMessage) {
        setTimeout(function() {
            successMessage.style.opacity = '0';
            setTimeout(function() {
                successMessage.remove();
            }, 300);
        }, 3000);
    }
});
</script>
