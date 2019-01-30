<?php
    $bdd = new PDO('mysql:host=localhost;dbname=entrainement','root','password');
    if($bdd){
        echo 'Base de donnée connecté <br />';
    }else {
        echo 'Probleme avec la connexion à la base de donnée <br />';
    }
?>
<?php
    if(!empty($_POST['pseudo']) AND !empty($_POST['message'])){
        $messages = htmlspecialchars($_POST['message']);
        $pseudosecure = htmlspecialchars($_POST['pseudo']);

        $insterMSG = $bdd->prepare('INSERT INTO messagerie(pseudo, message) VALUES(?,?)');
        $insterMSG->execute(array($pseudosecure,$messages));
        echo 'Message envoyé avec succès <br />';
    }else{
        echo 'Remplissez tous les champs ! <br />';
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Messagerie</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
</head>
<body>
    <h1 style='text-align:center;'>Chat en PHP (Ajouter du AJAX svp)</h1>
    <div id="main">
    <p><u>Messages postés :</u></p>
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
            <form method='POST' action=''>
                <label>Pseudo :<input type='text' placeholder='votre pseudo' name='pseudo'></label><br />
                <label>Votre messages :<textarea name='message' placeholder='votre message' id="message"></textarea></label><br />
                <input type='submit' name="envoie" value="Envoyer">
            </form>
        <div>
    </div>
</body>
</html>