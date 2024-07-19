<?php

// Au début de votre script PHP
error_reporting(E_ERROR | E_PARSE); // Cacher les avertissements, afficher uniquement les erreurs graves


$userId = $nom = $prenom = $type = $email = $message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $userId = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $type = $_POST['type'];
    $email = $_POST['email'];

    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "telecom";

    // Activer les rapports d'erreur MySQLi
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // Création de la connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Préparer la requête SQL pour mettre à jour l'utilisateur
    $sql = "UPDATE utulisateur SET nom=?, prenom=?, type=?, email=? WHERE id=?";

    // Préparation de la requête
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Erreur de préparation de la requête SQL : ' . $conn->error);
    }

    // Liaison des paramètres et exécution de la requête
    $stmt->bind_param("ssssi", $nom, $prenom, $type, $email, $userId);

    if ($stmt->execute()) {
        $message = "Utilisateur mis à jour avec succès.";
    } else {
        $message = "Erreur lors de l'exécution de la requête : " . $stmt->error;
    }

    // Fermeture des ressources
    $stmt->close();
    $conn->close();
} else {
    // Récupérer les détails de l'utilisateur pour pré-remplir le formulaire
    if (isset($_GET['id'])) {
        $userId = $_GET['id'];

        // Connexion à la base de données
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "telecom";

        // Création de la connexion
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Requête pour récupérer les détails de l'utilisateur
        $sql = "SELECT id, nom, prenom, type, email FROM utulisateur WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die('Erreur de préparation de la requête SQL : ' . $conn->error);
        }

        // Liaison des paramètres et exécution de la requête
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Vérification s'il y a des résultats
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nom = $row['nom'];
            $prenom = $row['prenom'];
            $type = $row['type'];
            $email = $row['email'];
        } else {
            $message = "Aucun utilisateur trouvé avec cet ID.";
            // Optionnel : rediriger ou afficher un message d'erreur
        }

        // Fermeture des ressources
        $stmt->close();
        $conn->close();
    } else {
        $message = "ID d'utilisateur non spécifié.";
        // Optionnel : rediriger ou afficher un message d'erreur
    }
}

// Structure HEREDOC pour intégrer le HTML avec les valeurs PHP
echo <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Utilisateur</title>
    <link rel="stylesheet" href="modifier_utilisateur.css">
</head>
<body>
    <div class="container">
        <h2>Modifier Utilisateur</h2>
        <form action="update_user.php" method="POST">
            <input type="hidden" id="id" name="id" value="$userId">
            
            <label for="ancienNom">Ancien Nom:</label>
            <input type="text" id="ancienNom" name="ancienNom" readonly value="{$row['nom']}"><br><br>

            <label for="ancienPrenom">Ancien Prénom:</label>
            <input type="text" id="ancienPrenom" name="ancienPrenom" readonly value="{$row['prenom']}"><br><br>

            <label for="ancienType">Ancien Type:</label>
            <input type="text" id="ancienType" name="ancienType" readonly value="{$row['type']}"><br><br>

            <label for="ancienEmail">Ancien Email:</label>
            <input type="email" id="ancienEmail" name="ancienEmail" readonly value="{$row['email']}"><br><br>

            <label for="nom">Nouveau Nom:</label>
            <input type="text" id="nom" name="nom" value="$nom" required><br><br>
            
            <label for="prenom">Nouveau Prénom:</label>
            <input type="text" id="prenom" name="prenom" value="$prenom" required><br><br>
            
            <label for="type">Nouveau Type:</label>
            <select id="type" name="type" required>
                <option value="b2b" {if ($type == 'b2b') echo 'selected'}>B2B</option>
                <option value="ett" {if ($type == 'ett') echo 'selected'}>ETT</option>
                <option value="consultant" {if ($type == 'consultant') echo 'selected'}>Consultant</option>
            </select><br><br>
            
            <label for="email">Nouveau Email:</label>
            <input type="email" id="email" name="email" value="$email" required><br><br>
            
            <button type="submit">Modifier Utilisateur</button>
        </form>
        
        <p>$message</p>
    </div>
</body>
</html>
HTML;
?>
