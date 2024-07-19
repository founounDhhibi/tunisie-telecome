<?php
// fetch_contrats.php

// Paramètres de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "telecom";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer la date du formulaire
if (isset($_GET['date'])) {
    $date = $_GET['date'];

    // Requête SQL pour récupérer les contrats à la date spécifiée avec id_contrat et etat
    $sql = "SELECT id_contrat, date_contrat, type_contrat, montant, nombre_contrat, etat 
            FROM contrat 
            WHERE date_contrat = ?";

    // Préparer la requête
    $stmt = $conn->prepare($sql);

    // Binder les paramètres
    $stmt->bind_param("s", $date);

    // Exécuter la requête
    $stmt->execute();

    // Récupérer le résultat
    $result = $stmt->get_result();

    $contrats = array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $contrats[] = $row;
        }
    }

    // Fermer le statement
    $stmt->close();

    // Fermer la connexion à la base de données
    $conn->close();

    // Renvoyer les contrats au format JSON
    header('Content-Type: application/json');
    echo json_encode($contrats);
    exit;
} else {
    echo "Veuillez spécifier une date.";
}
?>
