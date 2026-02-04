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
                <li class="admin-nav-item active">
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
                    <h1>Site Settings</h1>
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
                <?php if (isset($pageData['success_message'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $pageData['success_message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <form method="post" action="/admin/settings">
                    <!-- General settings -->
                    <div class="admin-card mb-4">
                        <div class="admin-card-header">
                            <h5><i class="fas fa-cog"></i> General Settings</h5>
                        </div>
                        <div class="admin-card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="site_name" class="form-label">Site Name</label>
                                        <input type="text" class="form-control" id="site_name" name="site_name" value="<?= htmlspecialchars($pageData['settings']['title']) ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="site_description" class="form-label">Site Description</label>
                                        <input type="text" class="form-control" id="site_description" name="site_description" value="<?= htmlspecialchars($pageData['settings']['description']) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="admin_email" class="form-label">Admin Email</label>
                                        <input type="email" class="form-control" id="admin_email" name="admin_email" value="<?= htmlspecialchars($pageData['settings']['contact_email']) ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="posts_per_page" class="form-label">Posts Per Page</label>
                                        <input type="number" class="form-control" id="posts_per_page" name="posts_per_page" value="<?= htmlspecialchars($pageData['settings']['posts_per_page']) ?>" min="1" max="100">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content settings -->
                    <div class="admin-card mb-4">
                        <div class="admin-card-header">
                            <h5><i class="fas fa-file-alt"></i> Content Settings</h5>
                        </div>
                        <div class="admin-card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="max_upload_size" class="form-label">Max Upload Size (MB)</label>
                                        <input type="number" class="form-control" id="max_upload_size" name="max_upload_size" value="<?= htmlspecialchars($pageData['settings']['max_upload_size']) ?>" min="1" max="256">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="allowed_file_types" class="form-label">Allowed File Types</label>
                                        <input type="text" class="form-control" id="allowed_file_types" name="allowed_file_types" value="<?= htmlspecialchars($pageData['settings']['allowed_file_types']) ?>" placeholder="jpg,jpeg,png,gif,pdf">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Save button -->
                    <div class="text-end">
                        <form method="post">
                            <button type="submit" name="act" value="settings" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Settings
                            </button>
                        </form>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/admin-panel.js"></script>
</body>
</html> 