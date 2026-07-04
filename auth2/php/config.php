<?php
// ================================================
//  Connexion PDO — portfolio_db
// ================================================

try {
    $conn = new PDO('mysql:host=localhost;dbname=portfolio_db', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    die("Erreur : " . $ex->getMessage());
}