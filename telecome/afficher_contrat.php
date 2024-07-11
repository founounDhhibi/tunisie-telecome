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

// Requête SQL pour récupérer les contrats
$sql = "SELECT date_contrat, nombre_contrat, montant, type_contrat FROM contrat";
$result = $conn->query($sql);

$contrats = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $contrats[] = $row;
    }
}

// Fermer la connexion à la base de données
$conn->close();

// Renvoyer les contrats au format JSON
header('Content-Type: application/json');
echo json_encode($contrats);
?>
