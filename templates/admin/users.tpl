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
                <li class="admin-nav-item active">
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
                    <h1>User Management</h1>
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
                
                <!-- Search and filters -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" id="userSearch" placeholder="Search users...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="statusFilter">
                            <option value="">All Statuses</option>
                            <option value="user">User</option>
                            <option value="moderator">Moderator</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary" id="addUserBtn" type="button" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            <i class="fas fa-plus"></i> Add User
                        </button>
                    </div>
                </div>

                <!-- Users table -->
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h5><i class="fas fa-users"></i> All Users</h5>
                    </div>
                    <div class="admin-card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                        <tr>
                                            <th>Avatar</th>
                                            <th><button type="button" class="btn btn-link p-0 text-dark text-decoration-none user-sort-btn" data-sort-key="name">Name</button></th>
                                            <th><button type="button" class="btn btn-link p-0 text-dark text-decoration-none user-sort-btn" data-sort-key="nickname">Nickname</button></th>
                                            <th><button type="button" class="btn btn-link p-0 text-dark text-decoration-none user-sort-btn" data-sort-key="email">Email</button></th>
                                            <th><button type="button" class="btn btn-link p-0 text-dark text-decoration-none user-sort-btn" data-sort-key="status">Status</button></th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                    <?php if (isset($pageData['users']) && !empty($pageData['users'])): ?>
                                        <?php foreach ($pageData['users'] as $user): ?>
                                        <tr
                                            class="user-row"
                                            data-name="<?= htmlspecialchars(trim($user['first_name'] . ' ' . $user['last_name'])) ?>"
                                            data-nickname="<?= htmlspecialchars($user['nickname']) ?>"
                                            data-email="<?= htmlspecialchars($user['email']) ?>"
                                            data-status="<?= htmlspecialchars($user['status']) ?>"
                                        >
                                            <td>
                                                <?php if (!empty($user['logo']) && $user['logo'] !== 'none'): ?>
                                                    <img src="<?= htmlspecialchars($user['logo']) ?>" alt="Avatar" class="rounded-circle" width="40" height="40">
                                                <?php else: ?>
                                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></td>
                                            <td><?= htmlspecialchars($user['nickname']) ?></td>
                                            <td><?= htmlspecialchars($user['email']) ?></td>
                                            <td>
                                                <span class="badge bg-<?= $user['status'] === 'admin' ? 'danger' : ($user['status'] === 'moderator' ? 'warning text-dark' : 'success') ?>">
                                                    <?= ucfirst($user['status']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-outline-primary edit-user-btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editUserModal"
                                                        data-user-id="<?= $user['id'] ?>"
                                                        data-user-first-name="<?= htmlspecialchars($user['first_name']) ?>"
                                                        data-user-last-name="<?= htmlspecialchars($user['last_name']) ?>"
                                                        data-user-nickname="<?= htmlspecialchars($user['nickname']) ?>"
                                                        data-user-email="<?= htmlspecialchars($user['email']) ?>"
                                                        data-user-status="<?= htmlspecialchars($user['status']) ?>"
                                                    >
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <?php if ($user['status'] !== 'admin'): ?>
                                                    <button type="button" class="btn btn-sm btn-outline-danger delete-user-btn" data-user-id="<?= $user['id'] ?>">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No users found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <nav aria-label="User navigation" class="mt-4 d-none" id="usersPaginationNav">
                    <ul class="pagination justify-content-center" id="usersPagination"></ul>
                </nav>
            </div>
        </main>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <div class="mb-3">
                            <label for="editFirstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="editFirstName">
                        </div>
                        <div class="mb-3">
                            <label for="editLastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="editLastName">
                        </div>
                        <div class="mb-3">
                            <label for="editNickname" class="form-label">Nickname</label>
                            <input type="text" class="form-control" id="editNickname">
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail">
                        </div>
                        <div class="mb-3">
                            <label for="editStatus" class="form-label">Status</label>
                            <select class="form-select" id="editStatus">
                                <option value="user">User</option>
                                <option value="moderator">Moderator</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <small class="text-muted">Leave fields empty to keep the current values. Only status is always applied.</small>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveUserBtn">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="mb-3">
                            <label for="addFirstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="addFirstName" required>
                        </div>
                        <div class="mb-3">
                            <label for="addLastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="addLastName" required>
                        </div>
                        <div class="mb-3">
                            <label for="addNickname" class="form-label">Nickname</label>
                            <input type="text" class="form-control" id="addNickname" required>
                        </div>
                        <div class="mb-3">
                            <label for="addBirthday" class="form-label">Birthday</label>
                            <input type="date" class="form-control" id="addBirthday" required>
                        </div>
                        <div class="mb-3">
                            <label for="addEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="addEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="addPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="addPassword" required>
                        </div>
                        <div class="mb-3">
                            <label for="addStatus" class="form-label">Status</label>
                            <select class="form-select" id="addStatus">
                                <option value="user">User</option>
                                <option value="moderator">Moderator</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="createUserBtn">Create User</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/admin-panel.js"></script>
</body>
</html> 
