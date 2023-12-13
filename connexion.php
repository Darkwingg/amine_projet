<?php
$serveur = "localhost";
$user = "root";
$mdp = "root";
$base_de_donnees = "airbnb";
$connexion = new mysqli($serveur, $user, $mdp, $base_de_donnees);

if ($connexion->connect_error) {
    die("La connexion à la base de données a échoué : " . $connexion->connect_error);
}

?>
