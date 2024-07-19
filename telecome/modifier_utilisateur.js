// modifier_utilisateur.js

document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.editButton');
    
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const userId = button.getAttribute('data-id'); // Modification ici
            fetchUserDetails(userId);
        });
    });
});

function fetchUserDetails(userId) {
    fetch(`fetch_user_details.php?id=${userId}`) // Modification ici
        .then(response => response.json())
        .then(user => {
            displayUserDetails(user);
        })
        .catch(error => console.error('Erreur lors de la récupération des détails de l\'utilisateur :', error));
}

function displayUserDetails(user) {
    const userDetailsContainer = document.getElementById('userDetails');
    userDetailsContainer.innerHTML = ''; // Clear previous content

    const form = document.createElement('form');
    form.id = 'modifyUserForm';
    form.action = 'update_user.php'; // Script PHP pour mettre à jour l'utilisateur
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

    userDetailsContainer.appendChild(form);
    userDetailsContainer.classList.remove('hidden');
}
