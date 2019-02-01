<?php
    $bdd = new PDO('mysql:host=localhost;dbname=entrainement','root','password');
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
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
</head>
<body>
    <a href='http://myberry3.ddns.net/projet/' id='back'><< Retour</a>
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
                    $bdd = new PDO('mysql:host=localhost;dbname=entrainement','root','password');
                    $PrepAffMSG = $bdd->query('SELECT * FROM messagerie ORDER BY id ASC');
                    while($affMSG = $PrepAffMSG->fetch()){
                        echo '<b>'.$affMSG['pseudo']. '</b>: '.$affMSG['message']. '<br />';
                    }
                ?>
            </div>
            <div id='Envoie'>
                <form method='POST' action='' id='input_center'>
                    <label>Pseudo :</label><input type='text' placeholder='Votre pseudo' name='pseudo' value="<?php if(isset($pseudosecure)){echo $pseudosecure;}?>" ><br />
                    <label>Votre messages :</label><textarea name='message' placeholder='Votre message' id="Textarea"></textarea><br />
                    <input type='submit' name="envoie" value="Envoyer">
                </form>
            </div>
        </div>
    <script>
        setInterval('load_messages()',500);
        function load_messages(){
            $('#Message').load('load_messages.php');
            element = document.getElementById('#Message');
            element.scrollTop = element.scrollHeight;
        }
        
    </script>
</body>
</html>