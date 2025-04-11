<?php
global $pdo;
require '../includes/config.php';
require '../includes/functions.php';
require '../classes/students.php';
require_auth();

if (!isset($_GET['id'])) {
    redirect('index.php');
}

$studentModel = new Student($pdo);
$student = $studentModel->find($_GET['id']);

if (!$student) {
    redirect('index.php');
}

$title = "Student Details: " . sanitize($student['name']);
require '../includes/header.php';
?>

    <h1>Student Details</h1>
    <div class="student-profile">
        <?php if ($student['image']): ?>
            <div class="student-photo">
                <img src="/uploads/students/<?= $student['image'] ?>" alt="<?= sanitize($student['name']) ?>">
            </div>
        <?php endif; ?>

        <div class="student-info">
            <h2><?= sanitize($student['name']) ?></h2>
            <p><strong>ID:</strong> <?= $student['id'] ?></p>
            <p><strong>Birth Date:</strong> <?= $student['birthday'] ?></p>
            <p><strong>Section:</strong> <?= sanitize($student['section_name'] ?? 'Not assigned') ?></p>
        </div>
    </div>

    <div class="action-buttons">
        <a href="index.php" class="btn">Back to List</a>
        <?php if (is_admin()): ?>
            <a href="edit.php?id=<?= $student['id'] ?>" class="btn">Edit</a>
        <?php endif; ?>
    </div>

<?php require '../includes/footer.php'; ?>