<?php
    $bdd = new PDO('mysql:host=localhost;dbname=projet_chat','root','password');
    $req = $bdd->query('SELECT identifiant FROM compte');
    while($list = $req->fetch()){
        echo "<span style='margin-left:10px;'>".$list['identifiant']."</span><br />";
    }
?>