<?php
require '../includes/config.php';
session_destroy();
redirect('/auth/login.php');