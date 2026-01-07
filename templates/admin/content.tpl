<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageData['title'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/admin-panel.css" rel="stylesheet">
</head>
<body class="admin-body">
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <nav class="admin-sidebar">
            <div class="admin-sidebar-header">
                <h3><i class="fas fa-cogs"></i> Admin Panel</h3>
            </div>
            <ul class="admin-nav">
                <li class="admin-nav-item">
                    <a href="/admin" class="admin-nav-link">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="admin-nav-item active">
                    <a href="/admin/content" class="admin-nav-link">
                        <i class="fas fa-file-alt"></i>
                        <span>Content</span>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="/admin/users" class="admin-nav-link">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="/admin/settings" class="admin-nav-link">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="/admin/reports" class="admin-nav-link">
                        <i class="fas fa-chart-bar"></i>
                        <span>Reports</span>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="/" class="admin-nav-link">
                        <i class="fas fa-home"></i>
                        <span>Go to Site</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main content -->
        <main class="admin-main">
            <!-- Top panel -->
            <header class="admin-header">
                <div class="admin-header-left">
                    <h1>Content Management</h1>
                </div>
                <div class="admin-header-right">
                    <div class="admin-user-info">
                        <span>Welcome, Admin</span>
                        <a href="/" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="admin-content">
                <?php if (isset($pageData['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($pageData['error']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>
                
                <!-- Quick actions -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?= count($pageData['content']['blog']) ?></h3>
                                <p>Blog Posts</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-comments"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?= count($pageData['content']['forum']) ?></h3>
                                <p>Forum Topics</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?= count($pageData['content']['news']) ?></h3>
                                <p>News Articles</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?= count($pageData['content']['blog']) + count($pageData['content']['forum']) + count($pageData['content']['news']) ?></h3>
                                <p>Total Content</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content tabs -->
                <div class="admin-card">
                    <div class="admin-card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="contentTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="blog-tab" data-bs-toggle="tab" data-bs-target="#blog" type="button" role="tab">
                                    <i class="fas fa-newspaper"></i> Blog Posts
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="forum-tab" data-bs-toggle="tab" data-bs-target="#forum" type="button" role="tab">
                                    <i class="fas fa-comments"></i> Forum Topics
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="news-tab" data-bs-toggle="tab" data-bs-target="#news" type="button" role="tab">
                                    <i class="fas fa-bullhorn"></i> News
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="admin-card-body">
                        <div class="tab-content" id="contentTabContent">
                            <!-- Blog Posts Tab -->
                            <div class="tab-pane fade show active" id="blog" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Category</th>
                                                <th>Author</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?= implode('', $pageData['content_blog']) ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Forum Topics Tab -->
                            <div class="tab-pane fade" id="forum" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Category</th>
                                                <th>Author</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?= implode('', $pageData['content_forum']) ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- News Tab -->
                            <div class="tab-pane fade" id="news" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Content</th>
                                                <th>Author</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?= implode('', $pageData['content_news']) ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Edit Content Modal -->
<div class="modal fade" id="editContentModal" tabindex="-1" aria-labelledby="editContentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editContentModalLabel">Edit Content</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editContentForm">
                    <input type="hidden" id="editContentId" name="content_id">
                    <input type="hidden" id="editContentType" name="content_type">
                    
                    <div class="mb-3">
                        <label for="editContentTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="editContentTitle" name="title" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editContentContent" class="form-label">Content</label>
                        <select class="form-select" id="editContentCategory" name="content" required>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveContentBtn">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and other scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/assets/js/admin-panel.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Edit content buttons
    const editContentBtns = document.querySelectorAll('.btn-outline-primary');
    editContentBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const contentId = this.closest('tr').querySelector('.delete-content-btn').getAttribute('data-content-id');
            const contentType = this.closest('tr').querySelector('.delete-content-btn').getAttribute('data-content-type');
            
            // Get content data
            fetch('/admin/ajax', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=get_content&content_id=${contentId}&content_type=${contentType}`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.content) {
                        document.getElementById('editContentId').value = contentId;
                        document.getElementById('editContentType').value = contentType;
                        document.getElementById('editContentTitle').value = data.content.title || '';

                        const select = document.getElementById('editContentCategory');
                        select.innerHTML = '';
                        data.categories.forEach(cat => {
                            const option = document.createElement('option');
                            option.value = cat;
                            option.textContent = cat;
                            if (cat === data.content.category_name) {
                                option.selected = true;
                            }
                            select.appendChild(option);
                        });

                        const modal = new bootstrap.Modal(document.getElementById('editContentModal'));
                        modal.show();
                    } else {
                        alert('Error loading content data');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading content data');
                });

        });
    });
    
    // Save content changes
    document.getElementById('saveContentBtn').addEventListener('click', function() {
        const formData = new FormData(document.getElementById('editContentForm'));
        formData.append('action', 'update_content');
        
        fetch('/admin/ajax', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Content updated successfully!');
                location.reload();
            } else {
                alert('Error updating content');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating content');
        });
    });
    
    // Delete content buttons
    const deleteContentBtns = document.querySelectorAll('.delete-content-btn');
    deleteContentBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const contentId = this.getAttribute('data-content-id');
            const contentType = this.getAttribute('data-content-type');
            
            if (confirm('Are you sure you want to delete this content?')) {
                fetch('/admin/ajax', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=delete_content&content_id=${contentId}&content_type=${contentType}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Content deleted successfully!');
                        location.reload();
                    } else {
                        alert('Error deleting content');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting content');
                });
            }
        });
    });
});
</script>
</body>
</html>
