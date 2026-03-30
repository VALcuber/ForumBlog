document.addEventListener('DOMContentLoaded', function() {
    const containerBlog = document.getElementById('pagination-target-blog');
    const containerForum = document.getElementById('pagination-target-forum');
    const containerBlogCat = document.getElementById('pagination-target-blog-cat');
    const containerForumCat = document.getElementById('pagination-target-forum-cat');
    const containerBlogSub = document.getElementById('pagination-target-blog-sub');
    const containerForumSub = document.getElementById('pagination-target-forum-sub');

    if (!containerBlog && !containerForum && !containerBlogCat && !containerForumCat && !containerBlogSub && !containerForumSub) return;

    // Track current pages for both sections
    let currentBlogPage = 1;
    let currentForumPage = 1;

    // Initial load
    fetchData(currentBlogPage, currentForumPage);

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.js-ajax-page');
        if (btn) {
            e.preventDefault();
            const newPage = parseInt(btn.getAttribute('data-page'));
            const type = btn.getAttribute('data-type'); // We'll add this attribute in render

            if (type === 'blog') {
                currentBlogPage = newPage;
            } else {
                currentForumPage = newPage;
            }

            fetchData(currentBlogPage, currentForumPage, type);
        }
    });

    function fetchData(blogPage, forumPage, lastClickedType = 'all') {
        // Visual feedback
        if (containerBlog && (lastClickedType === 'blog' || lastClickedType === 'all')) containerBlog.style.opacity = '0.4';
        if (containerForum && (lastClickedType === 'forum' || lastClickedType === 'all')) containerForum.style.opacity = '0.4';

        const formData = new FormData();
        formData.append('blog_page', blogPage);
        formData.append('forum_page', forumPage);

        fetch(window.location.href, {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(response => response.json())
            .then(data => {
                renderContent(data);
                if (containerBlog) containerBlog.style.opacity = '1';
                if (containerForum) containerForum.style.opacity = '1';
            });
    }

    function renderContent(data) {

        const buildItemHtml = (item) => {
            const posts = (item.posts || []).map((post) =>
                `<a href="${post.link}" class="mr-4">${post.title}</a>`
            ).join('');

            return `
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-2">${item.Category}</h5>
                        <a href="${item.category_link}">Go to category</a>
                    </div>
                    <div class="card-text mb-0">${posts}</div>
                </div>`;
        };

        const buildItemCatHtml = (item) => {
            const posts = (item.posts || []).map((post) =>
                `<a href="${post.link}" class="mr-4">${post.title}</a>`
            ).join('');

            return `
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-2">${item.Subcategory}</h5>
                        <a href="${item.subcategory_link}">Go to subcategory</a>
                    </div>
                    <div class="card-text mb-0">${posts}</div>
                </div>`;
        };

        const buildItemSubHtml = (item) => {
            const posts = (item.posts || []).map((post) =>
                `<a href="${post.link}" class="mr-4">${post.title}</a>`
            ).join('');

            return `
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-2">${item.Description}</h5>
                        <a href="${item.description_link}">Go to post</a>
                    </div>
                </div>`;
        };

        // Added 'type' parameter to buttons
        const buildPaginationHtml = (pagination, type) => {
            if (!pagination || pagination.total <= 1) return '';
            let html = '<div class="mt-auto pt-3"><nav><ul class="pagination pagination-sm mb-0 justify-content-center">';
            for (let i = 1; i <= pagination.total; i++) {
                const activeClass = (i == pagination.current) ? 'btn-primary text-white' : 'btn-outline-primary';
                html += `
                    <li class="page-item me-1">
                        <button class="btn btn-sm ${activeClass} js-ajax-page" data-page="${i}" data-type="${type}">${i}</button>
                    </li>`;
            }
            return html + '</ul></nav></div>';
        };

        if (containerBlog && data.blog) {
            containerBlog.innerHTML = data.blog.items.map(buildItemHtml).join('') +
                buildPaginationHtml(data.blog.pagination, 'blog');
        }

        if (containerForum && data.forum) {
            containerForum.innerHTML = data.forum.items.map(buildItemHtml).join('') +
                buildPaginationHtml(data.forum.pagination, 'forum');
        }

        if (containerBlogCat && data.blog) {
            containerBlogCat.innerHTML = data.blog.items.map(buildItemCatHtml).join('') +
                buildPaginationHtml(data.blog.pagination, 'blog');
        }

        if (containerForumCat && data.forum) {
            containerForumCat.innerHTML = data.forum.items.map(buildItemCatHtml).join('') +
                buildPaginationHtml(data.forum.pagination, 'forum');
        }

        if (containerBlogSub && data.blog) {
            containerBlogSub.innerHTML = data.blog.items.map(buildItemSubHtml).join('') +
                buildPaginationHtml(data.blog.pagination, 'blog');
        }

        if (containerForumSub && data.forum) {
            containerForumSub.innerHTML = data.forum.items.map(buildItemSubHtml).join('') +
                buildPaginationHtml(data.forum.pagination, 'forum');
        }
    }

});