<?php
// Paramètres de connexion à la base de données
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

// Démarrer la session pour accéder à $_SESSION
session_start();

// Vérifier si les variables POST sont définies
if (isset($_POST['date_contrat'], $_POST['nombre_contrat'], $_POST['montant'], $_POST['type_contrat'])) {
    $date_contrat = $_POST['date_contrat'];
    $nombre_contrat = $_POST['nombre_contrat'];
    $montant = $_POST['montant'];
    $type_contrat = $_POST['type_contrat'];
    
    // Récupérer user_type depuis la session
    if (isset($_SESSION['user_type'])) {
        $user_type = $_SESSION['user_type'];
    } else {
        echo "Erreur: user_type non défini.";
        exit;
    }

    // Valider les entrées
    if (empty($date_contrat) || !is_numeric($nombre_contrat) || !is_numeric($montant) || empty($type_contrat)) {
        echo "Tous les champs doivent être remplis correctement.";
        exit;
    }

    // Préparer et exécuter la requête SQL
    $stmt = $conn->prepare("INSERT INTO contrat (date_contrat, nombre_contrat, montant, type_contrat, user_type) VALUES (?, ?, ?, ?, ?)");
    
    // Utiliser la chaîne de type appropriée pour bind_param
    $stmt->bind_param("sidss", $date_contrat, $nombre_contrat, $montant, $type_contrat, $user_type);

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
