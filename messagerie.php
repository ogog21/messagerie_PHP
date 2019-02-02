<?php
session_start();
    $bdd = new PDO('mysql:host=localhost;dbname=projet_chat','root','password');
    if($bdd){
        $infoBD = 'Base de donnée connecté <br />';
    }else {
        $infoBD = 'Probleme avec la connexion à la base de donnée <br />';
    }
    if(!empty($_POST['pseudo']) AND !empty($_POST['message'])){
        $messages = htmlspecialchars($_POST['message']);
        $pseudosecure = htmlspecialchars($_POST['pseudo']);

        $insterMSG = $bdd->prepare('INSERT INTO messagerie(pseudo, message) VALUES(?,?)');
        $insterMSG->execute(array($pseudosecure,$messages));
        $Rchamp = 'Message envoyé avec succès <br />';
    }else{
        $Rchamp = 'Remplissez tous les champs ! <br />';
    }
    if(isset($_POST['clear'])){
        $bdd->exec('DELETE FROM messagerie');
        $clear = 'Supprimer <br />';
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Messagerie</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style/messagerie.css" />
</head>
<body>
    <a href='deconnexion.php' id='back'><< Se Déconnecter</a>
    <div id='block_actu'>
        <p id='actu'>Actu de la page</p>
        <?php
            if(isset($Rchamp)){
                echo $Rchamp;
            }
            if(isset($clear)){
                echo $clear;
            }
            if(isset($infoBD)){
                echo $infoBD;
            }
        ?>
    </div>
    <div id='main'>
        <h1 style='text-align:center;'>Chat en PHP w/ jQuery</h1>
            <form method='POST' action='' id='clear_button'><input type='submit' name='clear' value='Clear'></form>
            <div id="Message">
                <?php
                    $PrepAffMSG = $bdd->query('SELECT * FROM messagerie ORDER BY id ASC');
                    while($affMSG = $PrepAffMSG->fetch()){
                        echo '<b>'.$affMSG['pseudo']. '</b>: '.$affMSG['message']. '<br />';
                    }
                ?>
            </div>
            <?php
                if(isset($_SESSION['identifiant'])){
            ?>
            <div id='Envoie'>
                <form method='POST' action='' id='input_center'>
                    <label>Pseudo :</label><input type='text' placeholder='Votre pseudo' name='pseudo' readonly value="<?php if(isset($_SESSION['identifiant'])){echo $_SESSION['identifiant'];}?>"><br />
                    <label>Votre messages :</label><textarea name='message' placeholder='Votre message' id="Textarea"></textarea><br />
                    <input type='submit' name="envoie" value="Envoyer">
                </form>
            </div>
            <?php
                }else{
                    echo '<div id="need_connect">Vous devez être connecté pour envoyer des messages !
                    <br />
                    <a href="index.php">Se connecter</a>
                    </div>';
                }
            ?>
        </div>
    <script>
        setInterval('load_messages()',500);
        function load_messages(){
            $('#Message').load('load_messages.php');
        }
    </script>
</body>
</html>