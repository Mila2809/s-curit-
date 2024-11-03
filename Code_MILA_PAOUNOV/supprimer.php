<?php
require_once('bdd.php');
$getuser = $connexion->prepare('SELECT * FROM users WHERE pseudo = :pseudo');
$getuser->execute([
    'pseudo' => htmlspecialchars($_POST['pseudo'])
]);
$getuser = $getuser->fetch();
if (!$getuser || !$getuser['admin']) {
    exit("Access denied.");
}
$SupprimerArticle = $connexion->prepare('DELETE FROM Article WHERE slug = :slug');
$SupprimerArticle->execute([
    'slug' => htmlspecialchars($_POST['s'])
]);
header('Location: articleFront.php?users=' . urlencode($_POST['pseudo']));
exit();
?>
