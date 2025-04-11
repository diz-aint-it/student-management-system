<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

global $pdo;
require_once '../includes/config.php';
require_once '../includes/functions.php';


// Redirect if already logged in
if (is_logged_in()) {
    redirect('/etudiants-main/index.php');
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user input
    $username = sanitize($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    try {
        // Ensure that the table name matches the one in your database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();

        // Debugging: Output the fetched user (temporary)
        var_dump($user);  // Add this line temporarily to check if user is fetched correctly

        // Check if user was found and if the password is correct
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            redirect('/index.php');
        } else {
            $error = "Invalid credentials"; // User not found or password mismatch
        }
    } catch (PDOException $e) {
        // Show the database error in the development environment
        $error = "Database error: " . $e->getMessage();
    }
}

$title = "Login";
require '../includes/header.php';
?>

<div class="login-container">
    <h1>Login</h1>

    <?php if ($error): ?>
        <div class="alert error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="username">Username/Email:</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit" class="btn">Login</button>
    </form>
</div>

<?php require '../includes/footer.php'; ?>
