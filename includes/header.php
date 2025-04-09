<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Student Management' ?></title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
<header>
    <nav>
        <a href="/index.php">Home</a>
        <a href="/students/index.php">Students</a>
        <a href="/sections/index.php">Sections</a>
        <?php if (is_logged_in()): ?>
            <span>Welcome, <?= $_SESSION['user']['username'] ?></span>
            <a href="/auth/logout.php">Logout</a>
        <?php else: ?>
            <a href="/auth/login.php">Login</a>
        <?php endif; ?>
    </nav>
</header>
<main>