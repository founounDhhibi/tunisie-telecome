<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validation des Contrats en Attente</title>
    <style>
        /* Styles CSS ici */
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Contrats en Attente de Validation</h2>

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

    // Requête SQL pour sélectionner les contrats en attente
    $sql = "SELECT id_contrat, date_contrat, type_contrat, montant, nombre_contrat, user_type FROM contrat WHERE etat = 'en attente'";
    $result = $conn->query($sql);

    // Vérifier si des contrats en attente ont été trouvés
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<thead><tr><th>ID Contrat</th><th>Date Contrat</th><th>Type Contrat</th><th>Montant</th><th>Nombre Contrat</th><th>User Type</th><th>Action</th></tr></thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id_contrat']}</td>";
            echo "<td>{$row['date_contrat']}</td>";
            echo "<td>{$row['type_contrat']}</td>";
            echo "<td>{$row['montant']}</td>";
            echo "<td>{$row['nombre_contrat']}</td>";
            echo "<td>{$row['user_type']}</td>";
            echo "<td>";
            echo "<form action=\"update_contrat.php\" method=\"post\">";
            echo "<input type=\"hidden\" name=\"id_contrat\" value=\"{$row['id_contrat']}\">";
            echo "<input type=\"hidden\" name=\"action\" value=\"valider\">";
            echo "<button type=\"submit\">Valider</button>";
            echo "</form>";
            echo "<button onclick=\"confirmDelete({$row['id_contrat']})\">Supprimer</button>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>Aucun contrat en attente trouvé.</p>";
    }

    $conn->close();
    ?>

    <script>
    function confirmDelete(idContrat) {
        if (confirm("Êtes-vous sûr de vouloir supprimer ce contrat ?")) {
            // Requête AJAX pour supprimer le contrat
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_contrat.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        alert(xhr.responseText); // Affiche la réponse de PHP
                        // Recharger la page ou mettre à jour le tableau si nécessaire
                    } else {
                        alert("Erreur lors de la suppression du contrat.");
                    }
                }
            };
            xhr.send("id_contrat=" + idContrat + "&action=supprimer");
        }
    }
    </script>
</body>
</html>
