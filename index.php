<?php
require 'includes/config.php';
require 'includes/functions.php';
require_auth();

$title = "Dashboard";
require 'includes/header.php';
?>

    <h1>Welcome, <?= $_SESSION['user']['username'] ?>!</h1>
    <p>Role: <?= $_SESSION['user']['role'] ?></p>

<?php if (is_admin()): ?>
    <div class="admin-actions">
        <a href="/students/create.php" class="btn">Add Student</a>
        <a href="/sections/create.php" class="btn">Add Section</a>
    </div>
<?php endif; ?>

<?php require 'includes/footer.php'; ?>