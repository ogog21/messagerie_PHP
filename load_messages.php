<?php
        $bdd = new PDO('mysql:host=localhost;dbname=projet_chat','root','password');
        $PrepAffMSG = $bdd->query('SELECT * FROM messagerie ORDER BY id ASC');
        while($affMSG = $PrepAffMSG->fetch()){
        echo '<b>'.$affMSG['pseudo']. '</b>: '.$affMSG['message']. '<br />';
    }
?>