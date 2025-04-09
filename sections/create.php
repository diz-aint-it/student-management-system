<?php
global $pdo;
require '../includes/config.php';
require '../includes/functions.php';
require '../classes/Section.php';
require_admin();

$sectionModel = new Section($pdo);
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'designation' => sanitize($_POST['designation']),
        'description' => sanitize($_POST['description'] ?? '')
    ];

    if (empty($data['designation'])) {
        $error = 'Designation is required';
    } elseif ($sectionModel->create($data)) {
        $_SESSION['message'] = 'Section created successfully';
        redirect('index.php');
    } else {
        $error = 'Error creating section';
    }
}

$title = "Add New Section";
require '../includes/header.php';
?>

    <h1>Add New Section</h1>

<?php if ($error): ?>
    <div class="alert error"><?= $error ?></div>
<?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Designation*:
                <input type="text" name="designation" required>
            </label>
        </div>

        <div class="form-group">
            <label>Description:
                <textarea name="description" rows="3"></textarea>
            </label>
        </div>

        <button type="submit" class="btn">Create Section</button>
        <a href="index.php" class="btn secondary">Cancel</a>
    </form>

<?php require '../includes/footer.php'; ?>