<?php
    $bdd = new PDO('mysql:host=localhost;dbname=entrainement','root','password');
    if($bdd){
        echo 'Base de donnée connecté <br />';
    }else {
        echo 'Probleme avec la connexion à la base de donnée <br />';
    }
    if(!empty($_POST['pseudo']) AND !empty($_POST['message'])){
        $messages = htmlspecialchars($_POST['message']);
        $pseudosecure = htmlspecialchars($_POST['pseudo']);

        $insterMSG = $bdd->prepare('INSERT INTO messagerie(pseudo, message) VALUES(?,?)');
        $insterMSG->execute(array($pseudosecure,$messages));
        echo 'Message envoyé avec succès <br />';
    }else{
        echo 'Remplissez tous les champs ! <br />';
    }
    if(isset($_POST['clear'])){
        $bdd->exec('DELETE FROM messagerie');
        echo 'Supprimer';
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
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
</head>
<body>
    <h1 style='text-align:center;'>Chat en PHP w/ jQuery</h1>
    <div id="main">
        <form method='POST' action=''><input type='submit' name='clear' value='Clear' id='clear_button'></form>
    <p style='margin-left:50px;'><u>Messages postés :</u></p>
        <div id="post">
            <?php
                $bdd = new PDO('mysql:host=localhost;dbname=entrainement','root','password');
                $PrepAffMSG = $bdd->query('SELECT * FROM messagerie ORDER BY id DESC LIMIT 0,17');
                while($affMSG = $PrepAffMSG->fetch()){
                    echo '<b>'.$affMSG['pseudo']. '</b>: '.$affMSG['message']. '<br />';
                }
            ?>
        </div>
        <div id='envoie'>
            <form method='POST' action='' id='input_center'>
                <label>Pseudo :</label><input type='text' placeholder='votre pseudo' name='pseudo'><br />
                <label>Votre messages :</label><textarea name='message' placeholder='votre message' id="message"></textarea><br />
                <input type='submit' name="envoie" value="Envoyer">
            </form>
        <div>
    </div>
    <script>
        setInterval('load_messages()',500);
        function load_messages(){
            $('#post').load('load_messages.php');
        }
    </script>
</body>
</html>