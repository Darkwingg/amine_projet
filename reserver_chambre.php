<?php
include 'connexion.php';

if (isset($_GET['id'])) {
    $idChambre = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $dateArrivee = new DateTime($_POST['date_arrivee']);
        $dateDepart = new DateTime($_POST['date_depart']);
        $aujourdhui = new DateTime();

        if ($dateArrivee < $aujourdhui) {
            echo "La date d'arrivée ne peut pas être antérieure à aujourd'hui.";
        } else {
            $queryVerification = $connexion->prepare("SELECT * FROM book WHERE ID_ROOM = ? AND NOT ((DEPARTUREDATE <= ?) OR (ARRIVALDATE >= ?))");
            $queryVerification->bind_param("iss", $idChambre, $dateArrivee->format('Y-m-d'), $dateDepart->format('Y-m-d'));
            $queryVerification->execute();
            $resultVerification = $queryVerification->get_result();
            $queryVerification->close();

            if ($resultVerification->num_rows > 0) {
                echo "Impossible de réserver. La chambre est déjà réservée pour ces dates.";
            } else {
                // Ajouter ici la logique pour effectuer la réservation
                if ($dateArrivee > $dateDepart) {
                    echo "La date d'arrivée ne peut pas être antérieure à la date de départ.";
                } else {
                    // Insérer une nouvelle réservation dans la base de données
                    $query = $connexion->prepare("INSERT INTO book (ID_ROOM, ARRIVALDATE, DEPARTUREDATE, CREATIONDATE) VALUES (?, ?, ?, NOW())");
                    $query->bind_param("iss", $idChambre, $dateArrivee->format('Y-m-d'), $dateDepart->format('Y-m-d'));

                    if ($query->execute()) {
                        header("Location: toutes_les_reservations.php"); // Redirection vers la page avec toutes les réservations
                        exit();
                    } else {
                        echo "Erreur lors de la réservation : " . $connexion->error;
                    }

                    $query->close();
                }
            }
            $resultVerification->close();
        }
    }

    // Formulaire de réservation
    echo '<form action="reserver_chambre.php?id=' . $idChambre . '" method="POST">';
    echo 'Date d\'arrivée: <input type="date" name="date_arrivee" required><br>';
    echo 'Date de départ: <input type="date" name="date_depart" required><br>';
    echo '<input type="submit" value="Réserver">';
    echo '</form>';
} else {
    echo "ID de chambre non spécifié.";
}
?>
