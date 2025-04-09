<?php
global $pdo;
require '../includes/config.php';
require '../includes/functions.php';
require_auth();

$repo = new Repository($pdo, 'student');
$students = $repo->all();

$title = "Students List";
require '../includes/header.php';
?>

    <h1>Students</h1>

<?php if (is_admin()): ?>
    <a href="create.php" class="btn">Add New Student</a>
<?php endif; ?>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Birthday</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($students as $student): ?>
            <tr>
                <td><?= $student['id'] ?></td>
                <td><?= sanitize($student['name']) ?></td>
                <td><?= $student['birthday'] ?></td>
                <td>
                    <a href="detail.php?id=<?= $student['id'] ?>">View</a>
                    <?php if (is_admin()): ?>
                        | <a href="edit.php?id=<?= $student['id'] ?>">Edit</a>
                        | <a href="delete.php?id=<?= $student['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php require '../includes/footer.php'; ?>