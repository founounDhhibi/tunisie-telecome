<?php
$servername = "localhost";
$username = "root";
$password = ""; // Remplacez par le mot de passe de votre base de données
$dbname = "telecom";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_utilisateur = $_GET['id_utilisateur'];
$sql = "SELECT * FROM utulisateur WHERE id = '$id_utilisateur'";
$result = $conn->query($sql);

$response = array('exists' => false);
if ($result->num_rows > 0) {
    $response['exists'] = true;
}

echo json_encode($response);
$conn->close();
?>
