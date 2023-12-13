<?php
include 'connexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nouveauLibelle = $_POST['nouveau_libelle'];


    $query = $connexion->prepare("INSERT INTO room (LIBELLE) VALUES (?)");
    $query->bind_param("s", $nouveauLibelle);

    if ($query->execute()) {
        header('Location: index.php');
    } else {
        echo "Erreur lors de la création de la chambre : " . $connexion->error;
    }

    $query->close();
}
?>

<form action="creer_chambre.php" method="POST">
    Nouveau Libellé: <input type="text" name="nouveau_libelle" required>
    <input type="submit" value="Créer">
</form>
