<?php
    $bdd = new PDO('mysql:host=localhost;dbname=entrainement','root','password');
    $PrepAffMSG = $bdd->query('SELECT * FROM messagerie ORDER BY id DESC LIMIT 0,17');
    while($affMSG = $PrepAffMSG->fetch()){
        echo '<b>'.$affMSG['pseudo']. '</b>: '.$affMSG['message']. '<br />';
    }
?>