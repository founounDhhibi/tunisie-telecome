// script.js
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.deleteButton');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.getAttribute('data-id');
            const confirmDelete = confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur?");
            
            if (confirmDelete) {
                fetch(`delete_user.php?id=${userId}`, {
                    method: 'GET',
                })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    location.reload();
                })
                .catch(error => console.error('Error:', error));
            }
        });
    });
});
