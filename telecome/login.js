// Fonction pour l'animation lors du chargement de la page
function pageLoadAnimation() {
    console.log("Page loaded");
    // Ajoutez ici votre animation de chargement de la page si nécessaire
}

// Fonction pour l'animation lors du clic sur le logo
function logoClickAnimation() {
    console.log("Logo clicked");
    // Ajoutez ici votre animation lors du clic sur le logo si nécessaire
}

// Fonction pour l'animation lors du clic sur le texte de bienvenue
function welcomeClickAnimation() {
    console.log("Welcome text clicked");
    // Ajoutez ici votre animation lors du clic sur le texte de bienvenue si nécessaire
}

// Fonction de validation du formulaire de connexion
function validateForm() {
    var password = document.getElementById('Password1').value;

    if (password === "") {
        alert("Le mot de passe doit être rempli");
        return false;
    }

    var formData = new FormData(document.getElementById('login-form'));

    fetch('login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data.trim() === 'admin.html') {
            window.location.href = 'admin.html';
        } else if (data.trim() === 'utilisateur.html') {
            window.location.href = 'utilisateur.html';
        } else if (data.trim() === 'consultant.html') {
            window.location.href = 'consultant.html';
        } else {
            document.getElementById('error-message').innerText = data;
            document.getElementById('error-message').style.display = 'block';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('error-message').innerText = 'Une erreur s\'est produite lors de la connexion.';
        document.getElementById('error-message').style.display = 'block';
    });

    return false; // Empêche l'envoi du formulaire de manière traditionnelle
}
