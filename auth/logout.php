<?php
require '../includes/config.php';
require '../includes/functions.php'; // Ensure this line is correct

session_destroy();
redirect('/auth/login.php');