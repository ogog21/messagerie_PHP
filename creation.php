<?php 
    $bdd = new PDO('mysql:host=localhost;dbname=projet_chat','root','password');

    if(!empty($_POST['identifiant']) AND !empty($_POST['confirm_identifiant']) AND !empty($_POST['motdepasse']) AND !empty($_POST['confirm_motdepasse'])){
        $identifiant = htmlspecialchars($_POST['identifiant']);
        $confirm_identifiant = htmlspecialchars($_POST['confirm_identifiant']);
        $motdepasse = htmlspecialchars($_POST['motdepasse']);
        $confirm_motdepasse = htmlspecialchars($_POST['confirm_motdepasse']);
        if($identifiant == $confirm_identifiant){
            if($motdepasse == $confirm_motdepasse){
                $crypt_motdepasse = password_hash($motdepasse,PASSWORD_DEFAULT);
                $req = $bdd->prepare('INSERT INTO compte(identifiant,motdepasse) VALUES(?,?)');
                if($req){
                    $req->execute(array($identifiant,$crypt_motdepasse));
                }else {
                    echo 'Probleme de preparation de la requete';
                }
            }else {
                echo 'Les mots de passes ne sont pas identique';
            }
        }else {
            echo 'Les identifiants ne sont pas identique';
        }
    }else {
        echo 'Remplissez tous les champs <br />';
    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Création compte</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
    <br /><br /><br /><br /><br />
    <form method='POST' action=''>
        <label>Identifiant :</label><input type="text" name="identifiant"><br /><br />
        <label>Confirmer votre identifiant :</label><input type="text" name="confirm_identifiant"><br /><br />
        <label >Mot de passe :</label><input type="password" name="motdepasse"><br /><br />
        <label >Confirmer votre mot de passe :</label><input type="password" name="confirm_motdepasse"><br /><br />
        <input type="submit" value="Créer mon compte">
    </form>
    <a href='index.php'>Vers connexion.php</a>
</body>
</html>