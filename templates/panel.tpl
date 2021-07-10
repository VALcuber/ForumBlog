<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/img/icon.svg" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/admin.style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <title>Admin panel</title>
</head>
<body>
<div class="container-fluid px-0 d-flex flex-column flex-grow-1">
    <header class="header">
        <div class="d-flex align-items-center py-2 px-3 bg-info">
            <a href="/" class="text-white font-weight-bold">
                <i class="bi bi-arrow-left"></i>
                Back to home page
            </a>
            <h1 class="text-white mx-auto">Admin panel</h1>
            <span class="header__logo text-white font-weight-bold d-flex align-items-center justify-content-between">
          <i class="bi bi-person-fill"></i>
          <span class="mx-1">Admin</span>
          <i class="bi bi-chevron-down"></i>
        </span>
        </div>
    </header>
    <main class="main flex-grow-1">
        <div class="row h-100 mx-0" id="admin-container">
            <div class="col-4 bg-primary p-3">
                <ul class="list-group" id="actions-panel">
                    <li class="list-group-item list-group-item-action" data-action="news">Create News</li>
                    <li class="list-group-item list-group-item-action" data-action="blog">Create Blog</li>
                    <li class="list-group-item list-group-item-action" data-action="forum">Create Forum Topic</li>
                    <li class="list-group-item list-group-item-action" data-action="users">Manage users</li>
                    <li class="list-group-item list-group-item-action" data-action="comments">Manage users' comments</li>
                </ul>
            </div>
            <div class="col-8 p-3">
                <h3 class="text-center">Welcome to the admin panel !!!</h3>
            </div>
        </div>
    </main>
</div>
<script src="../assets/js/index.admin.js"></script>
</body>
</html>