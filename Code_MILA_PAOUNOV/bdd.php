<?php
try{
  $connexion = new PDO('mysql:host=localhost;dbname=iim_a2cdi_secu', 'root', '');
}
catch(Exception $e){
  die($e->getMessage());
}
$pdo = new PDO('mysql:host=localhost;dbname=iim_a2cdi_secu','root', '',);