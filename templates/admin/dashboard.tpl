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
                <li class="admin-nav-item active">
                    <a href="/admin" class="admin-nav-link">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="admin-nav-item">
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
                    <h1>Dashboard</h1>
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

            <!-- Dashboard content -->
            <div class="admin-content">
                <?php if (isset($pageData['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($pageData['error']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>
                
                <!-- Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?= isset($pageData['stats']['total_users']) ? $pageData['stats']['total_users'] : '0' ?></h3>
                                <p>Total Users</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?= isset($pageData['stats']['admin_users']) ? $pageData['stats']['admin_users'] : '0' ?></h3>
                                <p>Admin Users</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?= isset($pageData['stats']['blog_posts']) ? $pageData['stats']['blog_posts'] : '0' ?></h3>
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
                                <h3><?= isset($pageData['stats']['forum_topics']) ? $pageData['stats']['forum_topics'] : '0' ?></h3>
                                <p>Forum Topics</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-comment-dots"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?= isset($pageData['stats']['total_comments']) ? $pageData['stats']['total_comments'] : '0' ?></h3>
                                <p>Comments</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?= isset($pageData['stats']['total_news']) ? $pageData['stats']['total_news'] : '0' ?></h3>
                                <p>News Articles</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-folder"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?= isset($pageData['stats']['total_categories']) ? $pageData['stats']['total_categories'] : '0' ?></h3>
                                <p>Categories</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?= (isset($pageData['stats']['blog_posts']) ? $pageData['stats']['blog_posts'] : 0) + (isset($pageData['stats']['forum_topics']) ? $pageData['stats']['forum_topics'] : 0) ?></h3>
                                <p>Total Content</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <h5><i class="fas fa-users"></i> Recent Users</h5>
                            </div>
                            <div class="admin-card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Nickname</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($pageData['recent_activities']['recent_users']) && !empty($pageData['recent_activities']['recent_users'])): ?>
                                                <?php foreach ($pageData['recent_activities']['recent_users'] as $user): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></td>
                                                    <td><?= htmlspecialchars($user['nickname']) ?></td>
                                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                                    <td>
                                                        <span class="badge bg-<?= $user['status'] === 'admin' ? 'danger' : 'success' ?>">
                                                            <?= ucfirst($user['status']) ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted">No users found</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <h5><i class="fas fa-newspaper"></i> Recent Blog Posts</h5>
                            </div>
                            <div class="admin-card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Category</th>
                                                <th>Author</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($pageData['recent_activities']['recent_blog_posts']) && !empty($pageData['recent_activities']['recent_blog_posts'])): ?>
                                                <?php foreach ($pageData['recent_activities']['recent_blog_posts'] as $post): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($post['title']) ?></td>
                                                    <td><span class="badge bg-info"><?= htmlspecialchars($post['category']) ?></span></td>
                                                    <td><?= htmlspecialchars($post['author']) ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted">No blog posts found</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <h5><i class="fas fa-comments"></i> Recent Forum Topics</h5>
                            </div>
                            <div class="admin-card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Category</th>
                                                <th>Author</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($pageData['recent_activities']['recent_forum_topics']) && !empty($pageData['recent_activities']['recent_forum_topics'])): ?>
                                                <?php foreach ($pageData['recent_activities']['recent_forum_topics'] as $topic): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($topic['title']) ?></td>
                                                    <td><span class="badge bg-warning"><?= htmlspecialchars($topic['category']) ?></span></td>
                                                    <td><?= htmlspecialchars($topic['author']) ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted">No forum topics found</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <h5><i class="fas fa-bullhorn"></i> Recent News</h5>
                            </div>
                            <div class="admin-card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Content</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($pageData['recent_activities']['recent_news']) && !empty($pageData['recent_activities']['recent_news'])): ?>
                                                <?php foreach ($pageData['recent_activities']['recent_news'] as $news): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($news['title']) ?></td>
                                                    <td><?= htmlspecialchars(substr($news['content'], 0, 50)) ?>...</td>
                                                </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="2" class="text-center text-muted">No news found</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- System Information -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <h5><i class="fas fa-info-circle"></i> System Information</h5>
                            </div>
                            <div class="admin-card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="info-item">
                                            <strong>PHP Version:</strong>
                                            <span><?= isset($pageData['system_info']['php_version']) ? $pageData['system_info']['php_version'] : 'Unknown' ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-item">
                                            <strong>MySQL Version:</strong>
                                            <span><?= isset($pageData['system_info']['mysql_version']) ? $pageData['system_info']['mysql_version'] : 'Unknown' ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-item">
                                            <strong>Max Upload Size:</strong>
                                            <span><?= isset($pageData['system_info']['upload_max_filesize']) ? $pageData['system_info']['upload_max_filesize'] : 'Unknown' ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-item">
                                            <strong>Memory Limit:</strong>
                                            <span><?= isset($pageData['system_info']['memory_limit']) ? $pageData['system_info']['memory_limit'] : 'Unknown' ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <div class="info-item">
                                            <strong>Execution Time:</strong>
                                            <span><?= isset($pageData['system_info']['max_execution_time']) ? $pageData['system_info']['max_execution_time'] . ' sec' : 'Unknown' ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-item">
                                            <strong>Server Software:</strong>
                                            <span><?= isset($pageData['system_info']['server_software']) ? $pageData['system_info']['server_software'] : 'Unknown' ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-item">
                                            <strong>Database:</strong>
                                            <span>MySQL</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-item">
                                            <strong>Admin Panel:</strong>
                                            <span>v1.0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/assets/js/admin-panel.js"></script>
</body>
</html> 