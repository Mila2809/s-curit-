<?php
session_start();
require_once('bdd.php');
$getuser = $connexion->prepare('SELECT * FROM users WHERE pseudo = :pseudo');
$getuser->execute([
    'pseudo' => htmlspecialchars($_POST['pseudo'])
]);
$getuser = $getuser->fetch();
if (!$getuser || !$getuser['admin']) {
    exit("Access denied.");
}
if(
    !isset($_SESSION['csrf_article_add']) || 
    empty($_SESSION['csrf_article_add'])
    ){
    $_SESSION['csrf_article_add'] = bin2hex(random_bytes(32));
    echo $_SESSION['csrf_article_add'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=".">
    <title>Document</title>
</head>
<body>
    <form action="modif_traitement.php" method="POST">
        <label for="title">Titre :</label>
        <input type="text" name="title" id="title" placeholder="Article 1" value="<?php echo htmlspecialchars($_POST['title']); ?>">
        <br>
        <label for="content">Contenu :</label>
        <textarea name="content" id="content" rows="10" cols="30"><?php echo htmlspecialchars($_POST['content'], ENT_QUOTES); ?></textarea>
        <br>
        <label for="slug">Slug :</label>
        <input type="text" name="slug" id="slug" placeholder="article-1" value=<?php echo $_POST['s'] ;?> >
        <br>
        <input type="hidden" name="token" value="<?= $_SESSION["csrf_article_add"]?>">
        <input type="hidden" name="s" value="<?= htmlspecialchars(string: $_POST['s'])?>">
        <input type="hidden" value="<?php echo htmlspecialchars($_POST['pseudo']); ?>" name="pseudo">
        <input type="submit" class="button" name="modifier" value="Modifier">
    </form>
</body>
</html>