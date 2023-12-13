<?php
include 'connexion.php';
?>
<a href="toutes_les_reservations.php">Voir toutes les réservations</a>
<div class="container">
    <?php
    $query = "SELECT * FROM room";
    $resultat = $connexion->query($query);

    if ($resultat) {
        echo '<div class="hotel-list">';

        while ($row = $resultat->fetch_assoc()) {
            echo '<div class="hotel-item">';
            echo '<h3>Libellé: ' . $row['LIBELLE'] . '</h3>';

            // Boutons Modifier et Supprimer
            echo '<a href="modifier_chambre.php?id=' . $row['ID'] . '">Modifier</a>';
            echo '<a href="supprimer_chambre.php?id=' . $row['ID'] . '">Supprimer</a>';
            
            // Bouton Réserver
            echo '<a href="reserver_chambre.php?id=' . $row['ID'] . '">Réserver</a>';
            
            echo '</div>';
        }

        echo '</div>';

        $resultat->free();
    } else {
        echo "Erreur de requête : " . $connexion->error;
    }

    $connexion->close();
    ?>

    <a href="creer_chambre.php">Créer une chambre</a>
</div>
