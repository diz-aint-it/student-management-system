<?php
global $pdo;
require '../includes/config.php';
require '../includes/functions.php';
require '../classes/sections.php';
require '../classes/students.php';
require_auth();

if (!isset($_GET['id'])) {
    redirect('index.php');
}

$sectionModel = new Section($pdo);
$studentModel = new Student($pdo);

$section = $sectionModel->find($_GET['id']);
$students = $studentModel->paginate(1, 100, $_GET['id']); // Get students in this section

if (!$section) {
    redirect('index.php');
}

$title = "Section: " . sanitize($section['designation']);
require '../includes/header.php';
?>

    <h1><?= sanitize($section['designation']) ?></h1>

    <div class="section-details">
        <div class="section-info">
            <p><strong>ID:</strong> <?= $section['id'] ?></p>
            <?php if (!empty($section['description'])): ?>
                <p><strong>Description:</strong> <?= sanitize($section['description']) ?></p>
            <?php endif; ?>
            <p><strong>Total Students:</strong> <?= count($students) ?></p>
        </div>

        <?php if (!empty($students)): ?>
            <h2>Students in This Section</h2>
            <div class="student-list">
                <?php foreach ($students as $student): ?>
                    <div class="student-card">
                        <?php if ($student['image']): ?>
                            <img src="/uploads/students/<?= $student['image'] ?>"
                                 alt="<?= sanitize($student['name']) ?>" width="80">
                        <?php endif; ?>
                        <div>
                            <h3><?= sanitize($student['name']) ?></h3>
                            <p>Birthday: <?= $student['birthday'] ?></p>
                            <a href="/students/detail.php?id=<?= $student['id'] ?>" class="btn small">View</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="no-data">No students assigned to this section.</p>
        <?php endif; ?>
    </div>

    <div class="action-buttons">
        <a href="index.php" class="btn">Back to Sections</a>
        <?php if (is_admin()): ?>
            <a href="edit.php?id=<?= $section['id'] ?>" class="btn">Edit Section</a>
        <?php endif; ?>
    </div>

<?php require '../includes/footer.php'; ?>