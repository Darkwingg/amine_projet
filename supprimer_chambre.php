<?php
include 'connexion.php';

if (isset($_GET['id'])) {
    $idChambre = $_GET['id'];


    $query = $connexion->prepare("DELETE FROM room WHERE ID = ?");
    $query->bind_param("i", $idChambre);

    if ($query->execute()) {
        header('Location: index.php');
    } else {
        echo "Erreur lors de la suppression de la chambre : " . $connexion->error;
    }

    $query->close();
} else {
    echo "ID de chambre non spécifié.";
}
?>
