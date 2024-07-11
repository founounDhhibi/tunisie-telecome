// script.js
document.getElementById('addUserForm').addEventListener('submit', function(event) {
    // Ajout d'une animation à l'envoi du formulaire
    event.target.style.transform = 'scale(0.95)';
    setTimeout(function() {
        event.target.style.transform = 'scale(1)';
    }, 150);
});
