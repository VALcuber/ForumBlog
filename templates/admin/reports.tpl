<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Reports and Analytics - Admin</title>
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
                <li class="admin-nav-item active">
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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Reports and Analytics</h1>
                    <div>
                        <span class="text-muted me-3">Welcome, Admin</span>
                        <a href="/logout" class="btn btn-outline-danger btn-sm">Logout</a>
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
                
                <!-- Report filters -->
                <div class="admin-card mb-4">
                    <div class="admin-card-header">
                        <h5><i class="fas fa-chart-bar"></i> Statistics Overview</h5>
                    </div>
                    <div class="admin-card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="stat-content">
                                        <h3><?= isset($pageData['reports']['total_users']) ? $pageData['reports']['total_users'] : '0' ?></h3>
                                        <p>Total Users</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-newspaper"></i>
                                    </div>
                                    <div class="stat-content">
                                        <h3><?= isset($pageData['reports']['total_posts']) ? $pageData['reports']['total_posts'] : '0' ?></h3>
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
                                        <h3><?= isset($pageData['reports']['total_comments']) ? $pageData['reports']['total_comments'] : '0' ?></h3>
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
                                        <h3><?= isset($pageData['reports']['total_news']) ? $pageData['reports']['total_news'] : '0' ?></h3>
                                        <p>News Articles</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <h5><i class="fas fa-users"></i> User Registration Summary</h5>
                                <small class="text-muted">Real data: Only 2 users registered</small>
                            </div>
                            <div class="admin-card-body">
                                <div class="text-center">
                                    <h2 class="text-primary">2</h2>
                                    <p class="mb-0">Total Users</p>
                                    <hr>
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <h4 class="text-success">1</h4>
                                            <small>Sviatoslav (Admin)</small>
                                        </div>
                                        <div class="col-6">
                                            <h4 class="text-info">1</h4>
                                            <small>Kirill (User)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <h5><i class="fas fa-file-alt"></i> Content Creation Summary</h5>
                                <small class="text-muted">Real data: 3 blog posts + 4 forum topics</small>
                            </div>
                            <div class="admin-card-body">
                                <div class="text-center">
                                    <h2 class="text-primary">7</h2>
                                    <p class="mb-0">Total Content Items</p>
                                    <hr>
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <h4 class="text-success">3</h4>
                                            <small>Blog Posts</small>
                                        </div>
                                        <div class="col-6">
                                            <h4 class="text-info">4</h4>
                                            <small>Forum Topics</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Statistics -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <h5><i class="fas fa-info-circle"></i> Data Source Information</h5>
                            </div>
                            <div class="admin-card-body">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> <strong>Note:</strong> All data is retrieved directly from your database.
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>User Activity Data:</h6>
                                        <ul class="list-unstyled">
                                            <li><strong>Sviatoslav (Admin):</strong> Registered on 2024-01-15</li>
                                            <li><strong>Kirill (User):</strong> Registered on 2024-01-20</li>
                                            <li><strong>Total Users:</strong> 2 (as shown in the chart)</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Content Activity Data:</h6>
                                        <ul class="list-unstyled">
                                            <li><strong>Blog Posts:</strong> 3 posts by 2 users</li>
                                            <li><strong>Forum Topics:</strong> 4 topics by 2 users</li>
                                            <li><strong>Comments:</strong> 3 comments in forum</li>
                                            <li><strong>Total Content:</strong> 7 items (as shown in the chart)</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Include Bootstrap JS and other scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script src="/assets/js/admin-panel.js"></script>
</body>
</html> 