// ajouter_contrat.js
document.getElementById('contract-form').addEventListener('submit', function(event) {
    // Ajout d'une animation à l'envoi du formulaire (optionnel)
    event.target.style.transform = 'scale(0.95)';
    setTimeout(function() {
        event.target.style.transform = 'scale(1)';
    }, 150);
});
