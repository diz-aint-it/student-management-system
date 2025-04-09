<?php
global $pdo;
require '../includes/config.php';
require '../includes/functions.php';
require_admin();

if (!isset($_GET['id'])) redirect('/sections/index.php');

$repo = new Repository($pdo, 'section');
$repo->delete($_GET['id']);

redirect('/sections/index.php');