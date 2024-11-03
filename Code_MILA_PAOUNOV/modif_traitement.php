<?php
session_start(); 
if(
    !isset($_POST['token']) || 
    $_POST['token'] != $_SESSION['csrf_article_add']
){ 
    header("Location: index.php");
    exit();
}
require_once('bdd.php');
$ModifierArticle = $connexion->prepare('UPDATE `article` SET title = :title, content = :content, slug = :slug WHERE slug = :oldslug');
                $ModifierArticle->execute([
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'slug' => $_POST['slug'],
                'oldslug' =>$_POST['s']
            ]);
            header('Location: articleFront.php?users=' . $_POST['pseudo']);
    exit();
?>