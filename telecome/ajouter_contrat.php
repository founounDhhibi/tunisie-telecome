<?php
// Paramètres de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = ""; // Votre mot de passe de base de données
$dbname = "telecom";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérifier si les variables POST sont définies
if (isset($_POST['date_contrat'], $_POST['nombre_contrat'], $_POST['montant'], $_POST['type_contrat'])) {
    $date_contrat = $_POST['date_contrat'];
    $nombre_contrat = $_POST['nombre_contrat'];
    $montant = $_POST['montant'];
    $type_contrat = $_POST['type_contrat'];

    // Valider les entrées
    if (empty($date_contrat) || !is_numeric($nombre_contrat) || !is_numeric($montant) || empty($type_contrat)) {
        echo "Tous les champs doivent être remplis correctement.";
        exit;
    }

    // Préparer et exécuter la requête SQL
    $stmt = $conn->prepare("INSERT INTO contrat (date_contrat, nombre_contrat, montant, type_contrat) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdis", $date_contrat, $nombre_contrat, $montant, $type_contrat);

    if ($stmt->execute()) {
        echo "Contrat ajouté avec succès";
    } else {
        echo "Erreur lors de l'ajout du contrat: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Tous les champs doivent être remplis.";
}

$conn->close();
?>
