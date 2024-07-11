document.addEventListener('DOMContentLoaded', function() {
    showContent('afficher_contrat.html');
});

function showContent(page) {
    document.getElementById('content-frame').src = page;
}
