<!DOCTYPE html>

<html lang="en" data-theme="<?= htmlspecialchars($pageData['theme'] ?? 'dark', ENT_QUOTES, 'UTF-8') ?>">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $pageData['title'] ?></title>

    <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">

    <base href="<?= (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . htmlspecialchars($_SERVER['HTTP_HOST'], ENT_QUOTES, 'UTF-8') . '/' ?>">

    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/dark_theme.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script src="/assets/js/jquery.min.js"></script>

    <script src="/assets/js/bootstrap.min.js"></script>


</head>