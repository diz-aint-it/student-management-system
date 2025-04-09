<?php
global $pdo;
require '../includes/config.php';
require '../includes/functions.php';

// Redirect if already logged in
if (is_logged_in()) {
    redirect('/index.php');
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    try {
        $stmt = $pdo->prepare("SELECT * FROM user WHERE username = ? OR email = ?");
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            redirect('/index.php');
        } else {
            $error = "Invalid credentials";
        }
    } catch (PDOException $e) {
        $error = "Database error";
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