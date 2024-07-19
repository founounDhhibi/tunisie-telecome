<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Utilisateur</title>
    <link rel="stylesheet" href="modifier_utilisateur.css">
</head>
<body>
    <div class="container">
        <h2>Modifier un Utilisateur</h2>
        
        <!-- Zone de recherche par ID -->
        <form action="modifier_utilisateur.php" method="GET">
            <label for="userId">Rechercher par ID:</label>
            <input type="text" id="userId" name="userId" required>
            <button type="submit">Rechercher</button>
        </form>
        
        <table id="userTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Type</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Configuration de la connexion à la base de données
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "telecom";

                // Création de la connexion
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Vérification de la connexion
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Requête SQL pour sélectionner les utilisateurs à afficher (excluant l'admin)
                $sql = "SELECT id, nom, prenom, type, email FROM utulisateur WHERE type <> 'admin'";
                
                // Vérification si un utilisateur spécifique est recherché
                if (isset($_GET['userId'])) {
                    $userId = $_GET['userId'];
                    $sql .= " AND id = $userId";
                }
                
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["nom"] . "</td>";
                        echo "<td>" . $row["prenom"] . "</td>";
                        echo "<td>" . $row["type"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td><a href='update_user.php?id=" . $row["id"] . "'>Modifier</a></td>"; // Lien vers le formulaire de modification
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Aucun utilisateur trouvé</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>