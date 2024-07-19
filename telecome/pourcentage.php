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

// Vérifier si le mois est sélectionné
if (isset($_POST['month'])) {
    $selected_month = $_POST['month'];

    // Préparer la requête pour calculer le nombre de contrats par type d'utilisateur pour le mois sélectionné
    $sql = "SELECT user_type, COUNT(*) AS total_contrats FROM contrat WHERE DATE_FORMAT(date_contrat, '%Y-%m') = ? GROUP BY user_type";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selected_month);
    $stmt->execute();
    $result = $stmt->get_result();

    // Tableau pour stocker les résultats
    $contrats_par_type = array(
        'b2b' => 0,
        'ett' => 0,
        'admin' => 0
    );

    // Calculer le nombre total de contrats pour le mois sélectionné
    $total_contrats_mois = 0;
    while ($row = $result->fetch_assoc()) {
        $contrats_par_type[$row['user_type']] = $row['total_contrats'];
        $total_contrats_mois += $row['total_contrats'];
    }

    // Vérifier si aucun contrat n'a été trouvé pour le mois sélectionné
    if ($total_contrats_mois == 0) {
        echo " Aucun contrat trouvé pour le mois sélectionné.";
        exit;
    }

    // Calculer les pourcentages
    $pourcentage_b2b = ($contrats_par_type['b2b'] / $total_contrats_mois) * 100;
    $pourcentage_ett = ($contrats_par_type['ett'] / $total_contrats_mois) * 100;
    $pourcentage_admin = ($contrats_par_type['admin'] / $total_contrats_mois) * 100;

    // Embedding the HTML structure
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Calcul des Taux des Contrats</title>
    <style>
    /* CSS styles here */
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        margin: 0;
        padding: 0;
    }
    .container {
        max-width: 600px;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
        text-align: center;
        color: #333;
    }
    form {
        margin-bottom: 20px;
        text-align: center;
    }
    label {
        font-weight: bold;
    }
    input[type="month"] {
        padding: 8px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    button {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
    button:hover {
        background-color: #0056b3;
    }
    #errorMsg {
        color: red;
        text-align: center;
        margin-top: 10px;
        padding: 10px; /* Ajout de padding */
        border: 1px solid #dc3545; /* Bordure rouge */
        background-color: #f8d7da; /* Fond rose clair */
        border-radius: 4px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); /* Ombre légère */
    }
    #resultContainer {
        text-align: center;
        margin-top: 20px;
        font-size: 18px;
    }
    .result {
        margin-bottom: 10px;
    }
    .result label {
        font-weight: bold;
        margin-right: 10px;
    }
    .result span {
        font-weight: normal;
    }
</style>


    </head>
    <body>
        <div class="container">
            <h2>Calcul des Taux des Contrats</h2>
            <form action="pourcentage.php" method="post" id="tauxForm">
                <label for="month">Sélectionner le mois :</label>
                <input type="month" id="month" name="month" required>
                <button type="submit">Calculer Taux</button>
            </form>
            <div id="resultContainer">
                <?php
                // Afficher les résultats au format JSON décodé
                echo '<div class="result"><label>Pourcentage b2b :</label><span>' . round($pourcentage_b2b, 2) . '%</span></div>';
                echo '<div class="result"><label>Pourcentage ett :</label><span>' . round($pourcentage_ett, 2) . '%</span></div>';
                echo '<div class="result"><label>Pourcentage admin :</label><span>' . round($pourcentage_admin, 2) . '%</span></div>';
                echo '<div class="result"><label>Total des contrats ce mois :</label><span>' . $total_contrats_mois . '</span></div>';
                ?>
            </div>
        </div>
    </body>
    </html>
    <?php
} else {
    // Si le mois n'est pas sélectionné, renvoyer une erreur
    echo json_encode(array('error' => 'Le mois n\'a pas été sélectionné.'));
}

$stmt->close();
$conn->close();
?>
