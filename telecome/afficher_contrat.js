// afficher_contrat.js

document.addEventListener('DOMContentLoaded', function() {
    const dateForm = document.getElementById('dateForm');
    const contratsContainer = document.getElementById('contratsContainer');

    dateForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Empêcher le formulaire de se soumettre normalement

        const formData = new FormData(dateForm);
        const date = formData.get('date');

        fetch(`afficher_contrat.php?date=${date}`)
            .then(response => response.json())
            .then(data => {
                let html = '<h3>Contrats pour la date ' + date + '</h3>';
                html += '<table id="contratsTable">';
                html += '<thead><tr><th>ID Contrat</th><th>Date du Contrat</th><th>Type de Contrat</th><th>Montant</th><th>Nombre</th><th>État</th></tr></thead>';
                html += '<tbody>';

                data.forEach(contrat => {
                    html += '<tr>';
                    html += '<td>' + contrat.id_contrat + '</td>';
                    html += '<td>' + contrat.date_contrat + '</td>';
                    html += '<td>' + contrat.type_contrat + '</td>';
                    html += '<td>' + contrat.montant + '</td>';
                    html += '<td>' + contrat.nombre_contrat + '</td>';
                    html += '<td>' + contrat.etat + '</td>';
                    html += '</tr>';
                });

                html += '</tbody></table>';
                contratsContainer.innerHTML = html;
            })
            .catch(error => {
                console.error('Erreur de récupération des contrats :', error);
                contratsContainer.innerHTML = '<p>Une erreur s\'est produite lors de la récupération des contrats.</p>';
            });
    });
});
