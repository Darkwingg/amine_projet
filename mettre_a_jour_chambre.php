<?php
include 'connexion.php';

if (isset($_GET['id']) && isset($_POST['nouveau_libelle'])) {
    $idChambre = $_GET['id'];
    $nouveauLibelle = $_POST['nouveau_libelle'];


    $query = $connexion->prepare("UPDATE room SET LIBELLE = ? WHERE ID = ?");
    $query->bind_param("si", $nouveauLibelle, $idChambre);

    if ($query->execute()) {
        header('Location: index.php');
    } else {
        echo "Erreur lors de la mise à jour de la chambre : " . $connexion->error;
    }

    $query->close();
} else {
    echo "ID de chambre ou nouveau libellé non spécifié.";
}
?>
