<?php
global $pdo;
require '../includes/config.php';
require '../includes/functions.php';
require '../classes/Student.php';
require_admin();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect('index.php');
}

$studentModel = new Student($pdo);
$student = $studentModel->find($_GET['id']);

if (!$student) {
    redirect('index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($studentModel->delete($student['id'])) {
        $_SESSION['message'] = 'Student deleted successfully';
    } else {
        $_SESSION['error'] = 'Error deleting student';
    }
    redirect('index.php');
}

$title = "Delete Student";
require '../includes/header.php';
?>

    <h1>Delete Student</h1>
    <div class="confirmation-box">
        <p>Are you sure you want to delete <strong><?= sanitize($student['name']) ?></strong>?</p>
        <form method="POST">
            <button type="submit" class="btn danger">Confirm Delete</button>
            <a href="index.php" class="btn">Cancel</a>
        </form>
    </div>

<?php require '../includes/footer.php'; ?>