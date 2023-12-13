<?php
include 'connexion.php';

if (isset($_GET['id'])) {
    $idChambre = $_GET['id'];

    echo '<form action="mettre_a_jour_chambre.php?id=' . $idChambre . '" method="POST">';
    echo 'Nouveau Libellé: <input type="text" name="nouveau_libelle" required>';
    echo '<input type="submit" value="Mettre à jour">';
    echo '</form>';
} else {
    echo "ID de chambre non spécifié.";
}
?>
