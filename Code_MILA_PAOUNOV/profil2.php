<?php
require('bdd.php');
$idUser = $_GET["users"] ?? null;
if ($idUser) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE pseudo = :idUser");
    $stmt->execute(["idUser" => $idUser]);
    $users = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $users = false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profil.css">
    <title>Document</title>
</head>
<body>
        <div class="navbar">
            <?php $lien="articleFront.php?users=" . $_GET ["users"] ?>
            <a href=<?=$lien?> class="Acceuil">Acceuil</a>
            <?php $lien="profil2.php?users=" . $_GET ["users"] ?>
            <a href=<?=$lien?> class="Profil">Profil</a>
            <?php $lien="index.php?users=" . $_GET ["users"] ?>
            <a href=<?=$lien?> class="Déconnexion">Déconnexion</a>
        </div>
    <div class="info">
    <?php if ($users): ?>
        <ul>
            <?php foreach ($users as $index => $value): ?>
                <li> <?= htmlspecialchars($index) . " : " . htmlspecialchars($value); ?>  </li>
            <?php endforeach; ?>
        </ul>
        <?php $lien = "suppression_compte.php?id=" . urlencode($users["idUser"]); ?>
        <button><a href="<?= $lien ?>">Supprimer le compte</a></button>
        <?php else: ?>
            <p>No user found or invalid user ID.</p>
    <?php endif; ?>
    </div>
</body>
</html>