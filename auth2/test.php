<?php
// ================================================
//  test.php — Tester la connexion PDO
//  Placez ce fichier à la racine de auth2/
//  Ouvrez : http://localhost/auth2/test.php
// ================================================

$host    = '127.0.0.1';   // essayez aussi 'localhost'
$dbname  = 'portfolio_db';
$user    = 'root';
$pass    = '';             // vide sur XAMPP par défaut
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo '<p style="color:green;font-size:1.3rem">✅ Connexion PDO réussie !</p>';

    // Vérifier que la table users existe
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->fetch()) {
        echo '<p style="color:green">✅ Table <strong>users</strong> trouvée.</p>';

        // Compter les utilisateurs
        $count = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
        echo '<p style="color:blue">👤 Nombre d\'utilisateurs : <strong>' . $count . '</strong></p>';
    } else {
        echo '<p style="color:orange">⚠️ Table <strong>users</strong> introuvable. Importez database.sql dans phpMyAdmin.</p>';
    }

} catch (PDOException $e) {
    echo '<p style="color:red;font-size:1.1rem">❌ Erreur PDO : ' . $e->getMessage() . '</p>';
    echo '<hr>';
    echo '<p><strong>Solutions à essayer :</strong></p>';
    echo '<ul>';
    echo '<li>Vérifiez que MySQL est démarré dans XAMPP/WAMP</li>';
    echo '<li>Changez <code>127.0.0.1</code> en <code>localhost</code> (ou inversement)</li>';
    echo '<li>Vérifiez le mot de passe root (vide sur XAMPP, "root" sur certains WAMP)</li>';
    echo '<li>Vérifiez que la base <strong>portfolio_db</strong> existe dans phpMyAdmin</li>';
    echo '</ul>';
}
