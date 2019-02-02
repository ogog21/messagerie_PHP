<?php 
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=projet_chat','root','password');

$identifiant = htmlspecialchars($_POST['identifiant']);
$req = $bdd->prepare('SELECT id, motdepasse FROM compte WHERE identifiant = :identifiant');
$req->execute(array('identifiant' => $identifiant));
$resultat = $req->fetch();

// Comparaison du pass envoyé via le formulaire avec la base
$isPasswordCorrect = password_verify($_POST['motdepasse'], $resultat['motdepasse']);

if (!$resultat)
{
    echo 'Mauvais identifiant !';
}
else
{
    if ($isPasswordCorrect) {
        $_SESSION['id'] = $resultat['id'];
        $_SESSION['identifiant'] = $identifiant;
        echo $_SESSION['identifiant'].'<br />';
        echo 'Vous êtes connecté !';
    }
    else {
        echo 'Mauvais mot de passe !';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Connexion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
    <br /><br /><br /><br /><br />
    <form method='POST' action=''>
        <label>Identifiant :</label><input type="text" name="identifiant"><br /><br />
        <label >Mot de passe :</label><input type="password" name="motdepasse"><br /><br />
        <input type="submit" value="Connexion">
        <br />
    </form>
    <?php
        if(isset($_SESSION['id']) AND isset($_SESSION['identifiant'])){
            echo '<a href="deconnexion.php">Se déconnecter</a><br />';
            echo '<a href="messagerie.php">Acceder à la messagerie publique</a><br />';
        }
        if(empty($_SESSION['id']) AND empty($_SESSION['identifiant'])){
            echo '<a href="creation.php">Se créer un compte</a><br />';
        }
    ?>
</body>
</html>