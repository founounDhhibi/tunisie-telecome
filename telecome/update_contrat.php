<?php
// update_contrat.php

if (isset($_POST['id_contrat'], $_POST['action'])) {
    $idContrat = $_POST['id_contrat'];
    $action = $_POST['action'];

    // Paramètres de connexion à la base de données (si nécessaire)
    $servername = "localhost";
    $username = "root";
    $password = ""; // Mettez à jour avec votre mot de passe MySQL
    $dbname = "telecom";

    // Créer la connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Préparer la requête pour mettre à jour l'état du contrat
    if ($action === 'valider') {
        $sql = "UPDATE contrat SET etat = 'validé' WHERE id_contrat = ?";
    } elseif ($action === 'supprimer') {
        $sql = "UPDATE contrat SET etat = 'supprimé' WHERE id_contrat = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idContrat);

    if ($stmt->execute()) {
        echo "État du contrat mis à jour avec succès.";
    } else {
        echo "Erreur lors de la mise à jour de l'état du contrat: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Paramètres manquants.";
}
?>
