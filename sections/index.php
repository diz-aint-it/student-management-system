<?php
global $pdo;
require '../includes/config.php';
require '../includes/functions.php';
require '../classes/Section.php';
require_auth();

$sectionModel = new Section($pdo);
$sections = $sectionModel->all();

$title = "Sections";
require '../includes/header.php';
?>

    <h1>Sections</h1>

<?php if (is_admin()): ?>
    <div class="action-bar">
        <a href="create.php" class="btn">Add New Section</a>
        <div class="export-buttons">
            <a href="/exports/export.php?type=excel&entity=section" class="btn">Export Excel</a>
            <a href="/exports/export.php?type=pdf&entity=section" class="btn">Export PDF</a>
        </div>
    </div>
<?php endif; ?>

    <table class="data-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Designation</th>
            <th>Students</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($sections as $section): ?>
            <tr>
                <td><?= $section['id'] ?></td>
                <td><?= sanitize($section['designation']) ?></td>
                <td><?= $sectionModel->countStudents($section['id']) ?></td>
                <td class="actions">
                    <a href="detail.php?id=<?= $section['id'] ?>" class="btn small">View</a>
                    <?php if (is_admin()): ?>
                        <a href="edit.php?id=<?= $section['id'] ?>" class="btn small">Edit</a>
                        <a href="delete.php?id=<?= $section['id'] ?>"
                           class="btn small danger"
                           onclick="return confirm('Delete this section?')">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php require '../includes/footer.php'; ?>