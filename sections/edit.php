<?php
global $pdo;
require '../includes/config.php';
require '../includes/functions.php';
require '../classes/Section.php';
require_admin();

if (!isset($_GET['id'])) {
    redirect('index.php');
}

$sectionModel = new Section($pdo);
$section = $sectionModel->find($_GET['id']);

if (!$section) {
    redirect('index.php');
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'designation' => sanitize($_POST['designation']),
        'description' => sanitize($_POST['description'] ?? '')
    ];

    if (empty($data['designation'])) {
        $error = 'Designation is required';
    } elseif ($sectionModel->update($section['id'], $data)) {
        $_SESSION['message'] = 'Section updated successfully';
        redirect('index.php');
    } else {
        $error = 'Error updating section';
    }
}

$title = "Edit Section: " . sanitize($section['designation']);
require '../includes/header.php';
?>

    <h1>Edit Section</h1>

<?php if ($error): ?>
    <div class="alert error"><?= $error ?></div>
<?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Designation*:
                <input type="text" name="designation"
                       value="<?= $section['designation'] ?>" required>
            </label>
        </div>

        <div class="form-group">
            <label>Description:
                <textarea name="description" rows="3"><?= $section['description'] ?></textarea>
            </label>
        </div>

        <button type="submit" class="btn">Update Section</button>
        <a href="index.php" class="btn secondary">Cancel</a>
    </form>

<?php require '../includes/footer.php'; ?>