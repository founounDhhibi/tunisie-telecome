<?php
session_start();

// Paramètres de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = ""; // Remplacez par le mot de passe de votre base de données
$dbname = "telecom";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérifier si le mot de passe POST est défini
if(isset($_POST['Password1'])) {
    // Récupérer le mot de passe du formulaire
    $password = $conn->real_escape_string($_POST['Password1']);

    // Requête SQL pour vérifier le mot de passe
    $sql = "SELECT * FROM utulisateur WHERE password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // L'utilisateur est trouvé
        $row = $result->fetch_assoc();
        $user_type = $row['type'];

        // Renvoyer le chemin de redirection en fonction du type d'utilisateur
        if ($user_type == 'admin') {
            echo 'admin.html';
        } elseif (in_array($user_type, ['ett', 'b2b'])) {
            echo 'utilisateur.html';
        } elseif ($user_type == 'consultant') {
            echo 'consultant.html';
        } else {
            echo "Type d'utilisateur non reconnu.";
        }
    } else {
        // Afficher un message d'erreur si le mot de passe est incorrect
        echo "Mot de passe incorrect.";
    }
} else {
    echo "Le mot de passe doit être rempli.";
}

$conn->close();
?>
