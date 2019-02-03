<?php
    session_start(); //demarrage session
    $bdd = new PDO('mysql:host=localhost;dbname=projet_chat','root','password');
    $req =$bdd->prepare('DELETE FROM compte WHERE identifiant = :identifiant');
    $req->execute(array('identifiant' => $_SESSION['identifiant']));
    header('Location:index.php?delete=true');
?>