<?php
session_start();

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

// Vérifier si les champs Email et Password sont définis et non vides
if(isset($_POST['Email']) && isset($_POST['Password1'])) {
    // Récupérer les valeurs des champs Email et Password
    $email = $_POST['Email'];
    $password = $_POST['Password1'];

    // Utilisation de requête préparée pour éviter les injections SQL
    $sql = "SELECT * FROM utulisateur WHERE email = ? AND password = ?";
    
    // Préparer la requête
    $stmt = $conn->prepare($sql);
    
    // Binder les paramètres
    $stmt->bind_param("ss", $email, $password);
    
    // Exécuter la requête
    $stmt->execute();
    
    // Récupérer le résultat
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // L'utilisateur est trouvé
        $row = $result->fetch_assoc();
        $user_type = $row['type'];

        // Renvoyer le chemin de redirection en fonction du type d'utilisateur
        if ($user_type == 'admin') {
            $_SESSION['user_type'] = 'admin';
            echo "admin.html"; // Rediriger vers la page admin.html
            exit();
        } elseif ($user_type =='ett') {
            $_SESSION['user_type'] = 'ett';
            echo "utilisateur.html"; // Rediriger vers la page utilisateur.html
            exit();
        } elseif ($user_type =='b2b') {
            $_SESSION['user_type'] = 'b2b';
            echo "utilisateur.html"; // Rediriger vers la page utilisateur.html
            exit();
        } elseif ($user_type == 'consultant') {
            $_SESSION['user_type'] = 'consultant';
            echo "consultant.html"; // Rediriger vers la page consultant.html
            exit();
        } else {
            echo "Type d'utilisateur non reconnu.";
        }
    } else {
        // Afficher un message d'erreur si les identifiants sont incorrects
        echo "Email ou mot de passe incorrect.";
    }

    // Fermer le statement
    $stmt->close();
} else {
    echo "Veuillez fournir à la fois l'email et le mot de passe.";
}

// Fermer la connexion à la base de données
$conn->close();
?>