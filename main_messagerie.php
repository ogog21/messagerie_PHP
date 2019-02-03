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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style/main_messagerie.css" />
    <script src="main.js"></script>
</head>
<body>
    <?php if(isset($_SESSION['id'],$_SESSION['identifiant'])){//Si est connecté ?>
    <div id='who_connect'>
        <?php 
            if(isset($_SESSION['id']) AND isset($_SESSION['identifiant'])){
                echo "<span id='nom_pseudo_connecte'>Connecté en tant que : <strong>".$_SESSION['identifiant']."</strong></span>";
                echo "<span id='se_deconnecter'><a href='deconnexion.php'>Se déconnecter</a></span>";
            }
        ?>
    </div>
    <div style='margin-top:50px;'>
        <div id="tableau_pseudo_connecte">
            <h3 id='name_list'>Liste de pseudos :</h3>
            <div id='list_pseudo'>
                <?php
                    $req = $bdd->query('SELECT identifiant FROM compte');
                    while($list = $req->fetch()){
                        echo "<span style='margin-left:10px;'>".$list['identifiant']."</span><br />";
                    }
                ?>
            </div>
        </div>
        <div id="tableau_nos_messages">
            <h3 id='name_message'>Vos messages :</h3>
            <?php
                if(isset($messages)){
                    echo "Vous avez <strong>VARIABLE</strong> message(s)";
                }else{
                    echo "Vous n'avez pas de message.";
                }
            ?>
        </div>
    </div>
    <?php //Si l'utilisateur n'est pas connecté
    }else {
        echo "Vous devez êtres connecté pour accéder à cette page !<br />";
        echo "<a href='index.php'>Se connecter</a></br />";
    }?>
    </div>
    <script>
        setInterval('load_messages()',500);
        function load_messages(){
            $('#list_pseudo').load('load_pseudo_existant.php');
        }
    </script>
</body>
</html>