<?php
// Enable error reporting and display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include configuration and functions
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';
?>

    <h1>Welcome to Student Management System</h1>

<?php if (is_admin()): ?>
    <div class="admin-actions">
        <a href="<?= BASE_URL ?>students/create.php" class="btn">Add Student</a>
        <a href="<?= BASE_URL ?>sections/create.php" class="btn">Add Section</a>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>