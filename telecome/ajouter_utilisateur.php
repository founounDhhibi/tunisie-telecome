<?php
// add_user.php
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

// Préparer et lier
$stmt = $conn->prepare("INSERT INTO utulisateur (nom, prenom, type, password, email) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nom, $prenom, $type, $password, $email);

// Récupérer les valeurs
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$type = $_POST['type'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$email = $_POST['email'];

// Exécuter la requête
if ($stmt->execute()) {
    echo "Nouvel utilisateur ajouté avec succès";
} else {
    echo "Erreur: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
