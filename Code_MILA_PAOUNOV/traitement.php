<?php
session_start();
header('Content-Type: application/json');

if (!isset($_POST['token']) || $_POST['token'] != $_SESSION['csrf_article_add']) {
  echo json_encode(['success' => false, 'message' => 'CSRF invalide']);
  exit;
}

unset($_SESSION['csrf_article_add']);

$title = !empty($_POST['title']) ? htmlspecialchars($_POST['title']) : null;
$content = !empty($_POST['content']) ? htmlspecialchars($_POST['content']) : null;
$slug = !empty($_POST['slug']) ? htmlspecialchars($_POST['slug']) : null;

if ($title && $content && $slug) {
  require_once 'bdd.php';

  $sauvegarde = $connexion->prepare(
    'INSERT INTO Article (title, content, slug) VALUES (:title, :content, :slug)'
  );
  $sauvegarde->execute([
    'title' => $title,
    'content' => $content,
    'slug' => $slug
  ]);

  if ($sauvegarde->rowCount() > 0) {
    echo json_encode(['success' => true, 'title' => $title, 'content' => nl2br($content)]);
    header('Location: articleFront.php?users=' . $_GET['users']);
    exit ();
  } else {
    echo json_encode(['success' => false, 'message' => 'Erreur de sauvegarde']);
  }
} else {
  echo json_encode(['success' => false, 'message' => 'Champs obligatoires manquants']);
}
