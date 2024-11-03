<?php
if(!isset($_GET['s']) || empty($_GET['s'])){
  die('<p>Article introuvable</p>');
}
require_once 'bdd.php';
$getArticle = $connexion->prepare(
  'SELECT title, content FROM Article WHERE slug = :slug LIMIT 1'
);
$getArticle->execute([
  'slug' => htmlspecialchars($_GET['s'])
]);
if($getArticle->rowCount() == 1){
  $article = $getArticle->fetch();
  echo '<h1>'. $article['title'] .'</h1>';
  echo '<p>'. $article['content'] .'</p>';
}
else{
  echo '<p>Article introuvable</p>';
}