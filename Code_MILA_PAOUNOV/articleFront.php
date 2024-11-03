<?php 
session_start();

if(!isset($_SESSION['csrf_article_add']) || empty($_SESSION['csrf_article_add'])) {
  $_SESSION['csrf_article_add'] = bin2hex(random_bytes(32));
}

if(!isset($_GET['users']) || empty($_GET['users'])) {
  die("Paramètre 'users' manquant");
}

require_once 'bdd.php';

$getuser = $connexion->prepare('SELECT * FROM users WHERE pseudo = :pseudo');
$getuser->execute([
  'pseudo' => htmlspecialchars($_GET['users'])
]);
$getuser = $getuser->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="article.css">
  <title>Gestion des articles</title>
</head>
<body>
  <div class="navbar">
    <?php 
    $lienAccueil = "articleFront.php?users=" . htmlspecialchars($_GET['users']);
    $lienProfil = "profil2.php?users=" . htmlspecialchars($_GET['users']);
    $lienDeconnexion = "index.php?users=" . htmlspecialchars($_GET['users']);
    ?>
    <a href="<?= $lienAccueil ?>" class="Acceuil">Accueil</a>
    <a href="<?= $lienProfil ?>" class="Profil">Profil</a>
    <a href="<?= $lienDeconnexion ?>" class="Déconnexion">Déconnexion</a>
  </div>
  
  <div class="rest">
    <div class="rest2">
      <?php 
      if(!$getuser || (isset($getuser['admin']) && $getuser['admin'])) { 
      ?>
      <form action="traitement.php?users=<?= htmlspecialchars($_GET['users']) ?>" method="POST" class="info">
        <label for="title">Titre :</label>
        <input type="text" name="title" id="title" placeholder="Article 1">
        <br>
        <label for="content">Contenu :</label>
        <textarea name="content" id="content" rows="10" cols="30"></textarea>
        <br>
        <label for="slug">Slug :</label>
        <input type="text" name="slug" id="slug" placeholder="article-1">
        <br>
        <input type="hidden" name="token" value="<?= $_SESSION['csrf_article_add']; ?>">
        <input class="ajouter" type="submit" name="ajouter" value="Ajouter">
      </form>
      <?php } ?>
      
      <div class="article">
        <?php 

        $getArticle = $connexion->prepare('SELECT title, content, slug FROM Article');
        $getArticle->execute();

        if($getArticle->rowCount() > 0) {
          foreach ($getArticle->fetchAll(PDO::FETCH_ASSOC) as $article) {
            echo '<div class="Blog">';
            echo '<h1>' . htmlspecialchars($article['title']) . '</h1>';
            echo '<hr>';
            echo '<p>' . nl2br(htmlspecialchars($article['content'])) . '</p>';
            echo '</div>';
            
            if(!$getuser || (isset($getuser['admin']) && $getuser['admin'])) { 
            ?>
            <div class="ms">
              <form action="supprimer.php" method="post">
                <input type="hidden" value="<?= htmlspecialchars($article['slug']); ?>" name="s">
                <input type="hidden" value="<?= htmlspecialchars($_GET['users']); ?>" name="pseudo">
                <input class="supprimer" type="submit" value="Supprimer">
              </form>
              <form action="modifier.php" method="post">
                <input type="hidden" value="<?= htmlspecialchars($article['slug']); ?>" name="s">
                <input type="hidden" value="<?= htmlspecialchars($article['title']); ?>" name="title">
                <input type="hidden" value="<?= htmlspecialchars($article['content']); ?>" name="content">
                <input type="hidden" value="<?= htmlspecialchars($_GET['users']); ?>" name="pseudo">
                <input class="modifier" type="submit" value="Modifier">
              </form>
            </div>
            <?php 
            }
          }
        } 
        ?>
      </div>
    </div>
  </div>
</body>
</html>
