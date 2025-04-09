<?php
function redirect(string $url): void {
    header("Location: $url");
    exit;
}

function sanitize(?string $input): string {
    return htmlspecialchars(trim($input ?? ''), ENT_QUOTES, 'UTF-8');
}

function is_logged_in(): bool {
    return !empty($_SESSION['user']);
}

function is_admin(): bool {
    return is_logged_in() && $_SESSION['user']['role'] === 'admin';
}

function require_auth(): void {
    if (!is_logged_in()) {
        redirect('/auth/login.php');
    }
}

function require_admin(): void {
    require_auth();
    if (!is_admin()) {
        redirect('/index.php');
    }
}

function handle_upload(string $field): ?string {
    if (empty($_FILES[$field]['name'])) return null;

    $file = $_FILES[$field];
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $ext;
    $target = UPLOAD_DIR . $filename;

    return move_uploaded_file($file['tmp_name'], $target) ? $filename : null;
}
?>