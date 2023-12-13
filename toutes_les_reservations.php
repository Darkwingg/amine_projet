<a href="index.php">Retour à la page d'accueil</a>
<?php
include 'connexion.php';

if (isset($_GET['delete_id'])) {
    $idReservation = $_GET['delete_id'];


    $query = $connexion->prepare("DELETE FROM book WHERE ID = ?");
    $query->bind_param("i", $idReservation);

    if ($query->execute()) {
        header('Location: toutes_les_reservations.php');
    } else {
        echo "Erreur lors de la suppression de la réservation : " . $connexion->error;
    }

    $query->close();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_id'])) {
    $idReservation = $_POST['update_id'];
    $arrivalDate = $_POST['arrival_date'];
    $departureDate = $_POST['departure_date'];


    $query = $connexion->prepare("UPDATE book SET ARRIVALDATE = ?, DEPARTUREDATE = ? WHERE ID = ?");
    $query->bind_param("ssi", $arrivalDate, $departureDate, $idReservation);

    if ($query->execute()) {
        header('Location: toutes_les_reservations.php');
    } else {
        echo "Erreur lors de la mise à jour de la réservation : " . $connexion->error;
    }

    $query->close();
}


$query = "SELECT * FROM book";
$resultat = $connexion->query($query);

if ($resultat) {
    echo '<div class="reservations-list">';

    while ($row = $resultat->fetch_assoc()) {
        echo '<div class="reservation-item">';
        echo '<p>ID Chambre: ' . $row['ID_ROOM'] . '</p>';
        echo '<p>Date d\'arrivée: ' . $row['ARRIVALDATE'] . '</p>';
        echo '<p>Date de départ: ' . $row['DEPARTUREDATE'] . '</p>';
        echo '<p>Date de création: ' . $row['CREATIONDATE'] . '</p>';


        echo '<a href="toutes_les_reservations.php?delete_id=' . $row['ID'] . '">Supprimer</a>';
        echo '<a href="#" onclick="showUpdateForm(' . $row['ID'] . ')">Modifier</a>';

        echo '</div>';
    }

    echo '</div>';

    $resultat->free();
} else {
    echo "Erreur de requête : " . $connexion->error;
}

$connexion->close();
?>

<script>
    function showUpdateForm(id) {
        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", "toutes_les_reservations.php");

        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "update_id");
        hiddenField.setAttribute("value", id);
        form.appendChild(hiddenField);

        var arrivalDate = prompt("Nouvelle date d'arrivée :");
        var departureDate = prompt("Nouvelle date de départ :");

        var arrivalInput = document.createElement("input");
        arrivalInput.setAttribute("type", "hidden");
        arrivalInput.setAttribute("name", "arrival_date");
        arrivalInput.setAttribute("value", arrivalDate);
        form.appendChild(arrivalInput);

        var departureInput = document.createElement("input");
        departureInput.setAttribute("type", "hidden");
        departureInput.setAttribute("name", "departure_date");
        departureInput.setAttribute("value", departureDate);
        form.appendChild(departureInput);

        document.body.appendChild(form);
        form.submit();
    }
</script>
