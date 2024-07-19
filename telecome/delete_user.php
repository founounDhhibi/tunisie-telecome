<?php
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "telecom";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete the user
    $stmt = $conn->prepare("DELETE FROM utulisateur WHERE id = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        echo "Utilisateur supprimé avec succès";
    } else {
        echo "Erreur: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID utilisateur manquant";
}
?>
