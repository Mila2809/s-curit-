<?php
session_start();
if (!isset($_SESSION['csrf_token_inscription']) || empty($_SESSION['csrf_token_inscription'])) {
    $_SESSION['csrf_token_inscription'] = bin2hex(random_bytes(32));
}
require ('bdd.php');
$content = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $stmt = $pdo->prepare("
        INSERT INTO users (pseudo, email, pwd)
        VALUES (:pseudo, :email, :pwd)
    ");
    $nbrInsert = $stmt->execute([
        ':pseudo' => $_POST['pseudo'],
        ':email' => $_POST['email'],
        ':pwd' => password_hash(
            $_POST['password'],
            PASSWORD_BCRYPT,
            []
        )
    ]);

    if($nbrInsert > 0) {
        $content = "<h1> Votre insertion a fonctionné !</h1>";
        header('Location: index.php');
        exit();
    } else {
        $content = "<h1> Une erreur est survenue lors de l'insertion !</h1>";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="insc.css">
    <title>Formulaire d'inscription</title>
    <link rel="stylesheet">
</head>
<body>
    <?= $content; ?>
    <div class="BORD">
        <h2>Formulaire d'inscription</h2>
        <form method="POST" action="inscription.php">
            <div class="form-group">
                <label for="pseudo">Pseudo</label>
                <input type="text" class="form-control" id="pseudo" name="pseudo" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirmation du mot de passe</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
            </div>
            <button href='index.php' type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
    </div>
</body>
</html>