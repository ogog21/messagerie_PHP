<?php 

session_start(); //demarrage session
$bdd = new PDO('mysql:host=localhost;dbname=projet_chat','root','password');

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Espace Messagerie</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style/main_messagerie.css" />
    <script src="main.js"></script>
</head>
<body>
    <?php if(isset($_SESSION['id'],$_SESSION['identifiant'])){//Si est connecté ?>
    <div id='who_connect'>
        <?php 
            if(isset($_SESSION['id']) AND isset($_SESSION['identifiant'])){
                echo "<span id='pseudo_connect'>Connecté en tant que <strong>".$_SESSION['identifiant']."</strong></span>";
                echo "<span id='bouton_desconnect'><a href='deconnexion.php'>Se déconnecter</a></span>";
            }
        ?>
    </div>
    <div style='margin-top:50px;'>
        <div>
                <h2>Liste des personnes connectées :</h2>
        </div>
        <div>
    </div>
    <?php //Si l'utilisateur n'est pas connecté
    }else {
        echo "Vous devez êtres connecté pour accéder à cette page !<br />";
        echo "<a href='index.php'>Se connecter</a></br />";
    }?>
    </div>
</body>
</html>