// Sélection de l'élément input
const input = document.getElementById('image-picker');
// Sélection de l'élément image
const preview = document.getElementById('image-preview');

// Ajout d'un écouteur d'événement sur le changement de fichier
input.addEventListener('change', function() {
    const file = this.files[0]; // Récupération du premier fichier sélectionné

    // Vérification si un fichier est sélectionné
    if (file) {
        const reader = new FileReader(); // Création d'un objet FileReader

        // Fonction de rappel appelée lorsque la lecture est terminée
        reader.onload = function() {
            preview.src = reader.result; // Mise à jour de la source de l'image avec les données de fichier
        }

        reader.readAsDataURL(file); // Lecture du contenu du fichier sous forme d'URL de données
    }
});
