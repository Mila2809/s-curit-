<?php 
require_once 'bdd.php';
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    $nom = $_POST["pseudo"];
    $pwd = $_POST["pwd"];
    $request = $pdo->prepare('SELECT * FROM users WHERE pseudo = :nom');
    $request->execute(["nom" => $nom]);
    $request = $request->fetch();
    if ($request && isset($request['pwd'])) {
        $hashedPassword = $request['pwd'];
        if (password_verify($pwd, $hashedPassword)) {
            echo "oui";
            header('Location: articleFront.php?users=' . $_POST['pseudo']);
            exit;
        }
    } else {
        echo "<p class='erreur'>Nom d'utilisateur ou mot de passe incorrect</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Document</title>
</head>
<body>
    <form action="index.php" method="POST">
        <div class="BOITE">
            <div class="B">
                <p>Utilisateur :</p>
                <input type="text" name="pseudo">
                <p>Mots de passe :</p>
                <input type="password" name="pwd">
                <button type="submit">se connecter</button>
                <hr>
                <button><a href="inscription.php">s'inscrire</a></button>
            </div>
        </div>
    </form>
</body>
</html>