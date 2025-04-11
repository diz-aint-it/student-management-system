<?php
global $pdo;
require '../includes/config.php';
require '../includes/functions.php';
require_once(__DIR__ . '/../classes/students.php'); // Corrected file name
require_once(__DIR__ . '/../classes/sections.php'); // Corrected file name

require_auth(); // Ensure the user is authenticated
require_admin(); // Ensure the user is an admin

$studentModel = new Student($pdo);
$sectionModel = new Section($pdo);
$sections = $sectionModel->all();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => sanitize($_POST['name']),
        'birthday' => $_POST['birthday'],
        'section_id' => $_POST['section_id'] ?: null,
        'image' => handle_upload('image')
    ];

    if ($studentModel->create($data)) {
        redirect('students/index.php');
    }
}

$title = "Add Student";
require '../includes/header.php';
?>

    <h1>Add New Student</h1>
    <form method="POST" enctype="multipart/form-data" action="<?= BASE_URL ?>students/create.php">
        <div class="form-group">
            <label>Full Name:
                <input type="text" name="name" required>
            </label>
        </div>

        <div class="form-group">
            <label>Birth Date:
                <input type="date" name="birthday" required>
            </label>
        </div>

        <div class="form-group">
            <label>Section:
                <select name="section_id">
                    <option value="">-- Select Section --</option>
                    <?php foreach ($sections as $section): ?>
                        <option value="<?= $section['id'] ?>">
                            <?= sanitize($section['designation']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>

        <div class="form-group">
            <label>Student Photo:
                <input type="file" name="image" accept="image/*">
            </label>
        </div>

        <button type="submit" class="btn">Save Student</button>
    </form>

<?php require '../includes/footer.php'; ?>