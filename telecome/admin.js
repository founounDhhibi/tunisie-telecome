﻿document.addEventListener('DOMContentLoaded', function() {
    showContent('afficher_contrat.html');
});

function showContent(page) {
    document.getElementById('content-frame').src = page;
}
// hethi teb3a modifier utilisateur

// admin.js

function searchUser() {
    const password = document.getElementById('password').value;

    // Fetch user data based on password
    fetch(`search_user.php?password=${password}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error); // Handle errors
            } else {
                displayUserDetails(data); // Display user details
            }
        })
        .catch(error => console.error('Erreur lors de la recherche d\'utilisateur :', error));
}

function displayUserDetails(user) {
    const userDetails = document.getElementById('user-details');
    userDetails.innerHTML = ''; // Clear previous content

    const form = document.createElement('form');
    form.id = 'modifyUserForm';
    form.action = 'modifier_utilisateur.php'; // PHP script to handle modification
    form.method = 'POST';

    const idInput = document.createElement('input');
    idInput.type = 'hidden';
    idInput.name = 'id';
    idInput.value = user.id;
    form.appendChild(idInput);

    const nomLabel = document.createElement('label');
    nomLabel.textContent = 'Nom:';
    form.appendChild(nomLabel);
    const nomInput = document.createElement('input');
    nomInput.type = 'text';
    nomInput.name = 'nom';
    nomInput.value = user.nom;
    form.appendChild(nomInput);

    const prenomLabel = document.createElement('label');
    prenomLabel.textContent = 'Prénom:';
    form.appendChild(prenomLabel);
    const prenomInput = document.createElement('input');
    prenomInput.type = 'text';
    prenomInput.name = 'prenom';
    prenomInput.value = user.prenom;
    form.appendChild(prenomInput);

    const typeLabel = document.createElement('label');
    typeLabel.textContent = 'Type:';
    form.appendChild(typeLabel);
    const typeInput = document.createElement('select');
    typeInput.name = 'type';
    const types = ['b2b', 'ett', 'consultant'];
    types.forEach(type => {
        const option = document.createElement('option');
        option.value = type;
        option.textContent = type.toUpperCase();
        if (user.type === type) {
            option.selected = true;
        }
        typeInput.appendChild(option);
    });
    form.appendChild(typeInput);

    const emailLabel = document.createElement('label');
    emailLabel.textContent = 'Email:';
    form.appendChild(emailLabel);
    const emailInput = document.createElement('input');
    emailInput.type = 'email';
    emailInput.name = 'email';
    emailInput.value = user.email;
    form.appendChild(emailInput);

    const submitButton = document.createElement('button');
    submitButton.type = 'submit';
    submitButton.textContent = 'Modifier Utilisateur';
    form.appendChild(submitButton);

    userDetails.appendChild(form);
}
