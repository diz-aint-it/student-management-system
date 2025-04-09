<?php
global $pdo;
require '../includes/config.php';
require '../includes/functions.php';
require '../classes/Student.php';
require_auth();

// Pagination
$page = max(1, $_GET['page'] ?? 1);
$perPage = 10;

$studentModel = new Student($pdo);
$students = $studentModel->paginate($page, $perPage);
$totalPages = ceil($studentModel->count() / $perPage);

$title = "Students";
require '../includes/header.php';
?>

    <h1>Students</h1>

<?php if (is_admin()): ?>
    <a href="create.php" class="btn">Add Student</a>
    <div class="export-buttons">
        <a href="/exports/export.php?type=excel&entity=student" class="btn">Export Excel</a>
        <a href="/exports/export.php?type=pdf&entity=student" class="btn">Export PDF</a>
    </div>
<?php endif; ?>

    <table>
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
                <td><?= sanitize($student['section_name'] ?? 'None') ?></td>
                <td>
                    <a href="detail.php?id=<?= $student['id'] ?>">View</a>
                    <?php if (is_admin()): ?>
                        | <a href="edit.php?id=<?= $student['id'] ?>">Edit</a>
                        | <a href="delete.php?id=<?= $student['id'] ?>"
                             onclick="return confirm('Delete this student?')">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>" class="btn">Previous</a>
        <?php endif; ?>

        <span>Page <?= $page ?> of <?= $totalPages ?></span>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>" class="btn">Next</a>
        <?php endif; ?>
    </div>

<?php require '../includes/footer.php'; ?>