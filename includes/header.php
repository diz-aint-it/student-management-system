<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Student Management' ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/style.css">
</head>
<body>
<header>
    <nav>
        <a href="<?= BASE_URL ?>">Home</a>
        <a href="<?= BASE_URL ?>students/index.php">Students</a>
        <a href="<?= BASE_URL ?>sections/index.php">Sections</a>
        <?php if (is_logged_in()): ?>
            <span>Welcome, <?= $_SESSION['user']['username'] ?></span>
            <a href="<?= BASE_URL ?>auth/logout.php">Logout</a>
        <?php else: ?>
            <a href="<?= BASE_URL ?>auth/login.php">Login</a>
        <?php endif; ?>
    </nav>
</header>
<main>