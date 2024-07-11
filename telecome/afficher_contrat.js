

document.addEventListener('DOMContentLoaded', function() {
    fetchContrats(); // Appeler la fonction pour récupérer et afficher les contrats au chargement de la page
});

function fetchContrats() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'afficher_contrat.php', true);
    xhr.onload = function() {
        if (xhr.status == 200) {
            var contrats = JSON.parse(xhr.responseText);
            displayContrats(contrats);
        } else {
            console.error('Erreur lors de la récupération des contrats');
        }
    };
    xhr.onerror = function() {
        console.error('Erreur de réseau');
    };
    xhr.send();
}

function displayContrats(contrats) {
    var tableHtml = '';

    contrats.forEach(contrat => {
        tableHtml += `<tr>
                        <td>${contrat.date_contrat}</td>
                        <td>${contrat.nombre_contrat}</td>
                        <td>${contrat.montant}</td>
                        <td>${contrat.type_contrat}</td>
                      </tr>`;
    });

    var contratsTable = document.getElementById('contratsTable');
    var tbody = contratsTable.querySelector('tbody');
    tbody.innerHTML = tableHtml;
}
