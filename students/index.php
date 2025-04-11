<?php
// Include configuration and functions
global $pdo;
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../classes/students.php'; // Corrected file name

require_auth(); // Ensure the user is authenticated

$studentModel = new Student($pdo);
$students = $studentModel->paginate(1, 10);

$title = "Students";
require '../includes/header.php';
?>

    <h1>Students</h1>

<?php if (is_admin()): ?>
    <div class="action-bar">
        <a href="create.php" class="btn">Add New Student</a>
        <div class="export-buttons">
            <a href="<?= BASE_URL ?>/exports/export.php?type=excel&entity=student">Export to Excel</a>
            <a href="<?= BASE_URL ?>/exports/export.php?type=pdf&entity=student"> or PDF</a>
        </div>

    </div>
<?php endif; ?>

    <table class="data-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Birthday</th>
            <th>Section</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($students as $student): ?>
            <tr>
                <td><?= $student['id'] ?></td>
                <td><?= sanitize($student['name']) ?></td>
                <td><?= $student['birthday'] ?></td>
                <td><?= sanitize($student['section_name'] ?? 'Not assigned') ?></td>
                <td class="actions">
                    <a href="detail.php?id=<?= $student['id'] ?>" class="btn small">View</a>
                    <?php if (is_admin()): ?>
                        <a href="edit.php?id=<?= $student['id'] ?>" class="btn small">Edit</a>
                        <a href="delete.php?id=<?= $student['id'] ?>"
                           class="btn small danger"
                           onclick="return confirm('Delete this student?')">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php require '../includes/footer.php'; ?>