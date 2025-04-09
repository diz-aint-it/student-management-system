<?php

try {
    $pdo = new PDO("mysql:host=127.0.0.1;port=4306;dbname=etudiant;charset=utf8", "root", "ayouta");
    // Affiche un message si la connexion réussit (optionnel)
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>