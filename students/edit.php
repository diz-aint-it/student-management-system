<?php
global $pdo;
require '../includes/config.php';
require '../includes/functions.php';
require '../classes/students.php';
require '../classes/sections.php';
require_admin();

if (!isset($_GET['id'])) redirect('index.php');

$studentModel = new Student($pdo);
$sectionModel = new Section($pdo);
$student = $studentModel->find($_GET['id']);
$sections = $sectionModel->all();

if (!$student) redirect('index.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => sanitize($_POST['name']),
        'birthday' => $_POST['birthday'],
        'section_id' => $_POST['section_id'] ?: null,
        'image' => $student['image'] // Keep existing unless changed
    ];

    // Handle new image upload
    if ($newImage = handle_upload('image')) {
        // Delete old image if exists
        if ($student['image']) {
            @unlink(UPLOAD_DIR . $student['image']);
        }
        $data['image'] = $newImage;
    }

    if ($studentModel->update($student['id'], $data)) {
        redirect('index.php');
    }
}

$title = "Edit Student";
require '../includes/header.php';
?>

    <h1>Edit Student</h1>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Full Name:
                <input type="text" name="name" value="<?= $student['name'] ?>" required>
            </label>
        </div>

        <div class="form-group">
            <label>Birth Date:
                <input type="date" name="birthday" value="<?= $student['birthday'] ?>" required>
            </label>
        </div>

        <div class="form-group">
            <label>Section:
                <select name="section_id">
                    <option value="">-- No Section --</option>
                    <?php foreach ($sections as $section): ?>
                        <option value="<?= $section['id'] ?>"
                            <?= $section['id'] == $student['section_id'] ? 'selected' : '' ?>>
                            <?= sanitize($section['designation']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>

        <div class="form-group">
            <label>Student Photo:
                <?php if ($student['image']): ?>
                    <img src="/uploads/students/<?= $student['image'] ?>" height="100" class="current-photo">
                    <br>Change:
                <?php endif; ?>
                <input type="file" name="image" accept="image/*">
            </label>
        </div>

        <button type="submit" class="btn">Update Student</button>
    </form>

<?php require '../includes/footer.php'; ?>