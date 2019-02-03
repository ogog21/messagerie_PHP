<?php 
session_start(); //demarrage session
$bdd = new PDO('mysql:host=localhost;dbname=projet_chat','root','password');

$identifiant = htmlspecialchars($_POST['identifiant']);
//Test si l'identifiant correspond
$req = $bdd->prepare('SELECT id, motdepasse FROM compte WHERE identifiant = :identifiant');
$req->execute(array('identifiant' => $identifiant));
$resultat = $req->fetch();

// Comparaison du pass envoyé via le formulaire avec la base
$isPasswordCorrect = password_verify($_POST['motdepasse'], $resultat['motdepasse']);
if(!empty($identifiant) AND !empty($_POST['motdepasse'])){ //Si les deux variables existent et sont remplies
    if (!$resultat) //Si l'identifiant ne match pas
    {
        $ERROR_Msg = 'Mauvais identifiant !';
    }
    else //Si l'idetifiant match alors
    {
        if ($isPasswordCorrect) { // On test si password_verify envoie True
            $_SESSION['id'] = $resultat['id'];
            $_SESSION['identifiant'] = $identifiant;
            $session_id = '<div id="welcome_user">Bienvenue <strong>'.$_SESSION['identifiant'].'</strong></div><br />';
            $SUCCES_Msg = '<div id="connect">Vous êtes connecté !</div>';
        }
        else {
            $ERROR_Msg = 'Mauvais mot de passe !<br />';
        }
    }
}else {
    $ERROR_Msg = 'Remplissez les champs !<br />';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Connexion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style/index.css" />
    <script src="main.js"></script>
</head>
<body>
    <div id='main'>
        <h3 style='text-align:center'>Connexion</h3>
        <?php //Si l'utilisateur est deja connecté on montre pas le forumaire de connexion
            if(isset($_SESSION['identifiant']) AND isset($_SESSION['id'])){
                if(isset($SUCCES_Msg) AND isset($session_id)){
                    echo $SUCCES_Msg;
                    echo $session_id;
                }
            }else{ //Si l'utilisateur n'est pas connecté on montre le forumaire de connexion
        ?>
        <div id='formulaire'>
            <form method='POST' action='index.php'>
                <label for='identifiant'>Identifiant :</label><input type="text" name="identifiant"><br /><br />
                <label for='motdepasse'>Mot de passe :</label><input type="password" name="motdepasse"><br /><br />
                <?php //Début messages info sur l'etat de connexion
                    if(isset($ERROR_Msg)){
                        echo $ERROR_Msg;
                    }
                    if(isset($_GET['deconnexion']) == true){
                        echo 'Vous êtes bien déconnecté <br />';
                    }//Fin messages info sur l'etat de connexion
                ?>
                <input type="submit" value="Connexion" id='connexion'>
                <br />
            </form>
        </div>
        <?php
            } //Si l'utilisateur est connecté on propose une deconnexion ou acces a la messagerie
            if(isset($_SESSION['id']) AND isset($_SESSION['identifiant'])){
                echo '<a href="deconnexion.php" class="creation_deconnexion">Se déconnecter</a><br />';
                echo '<a href="main_messagerie.php" id="to_messagerie">Acceder à l\'espace de messagerie</a><br />';
            } //Sinon on propose de se creer un compte
            if(empty($_SESSION['id']) AND empty($_SESSION['identifiant'])){
                echo '<a href="creation.php" class="creation_deconnexion">Se créer un compte</a><br />';
            }
        ?>
    </div>
</body>
</html>