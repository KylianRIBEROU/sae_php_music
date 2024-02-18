
document.addEventListener("DOMContentLoaded", function() {

    // Sélection de l'élément input
// Sélection de l'élément input
let input = document.getElementById('image-picker');
// Sélection de l'élément image
let preview = document.getElementById('image-preview');

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

        // Lecture du contenu du fichier en tant que URL de données
        reader.readAsDataURL(file);
    }
    });

    const ajoutGenreBtn = document.querySelector('#ajout-genre');
    let divFormAjoutGenre = document.querySelector('#add-genre-form');

    ajoutGenreBtn.addEventListener('click', function() {
        if (divFormAjoutGenre.style.display === "none") {
            divFormAjoutGenre.style.display = "block";
        }
        else {
            divFormAjoutGenre.style.display = "none";
        }

        // let form2 = document.getElementById("form-genre");

        // document.getElementById("valider-nouveau-genre").addEventListener("click", function () {
        //     form2.submit();
        // });
    });


    let inputNouveauGenre = document.querySelector('#nouveau-genre');

    let classGenresCheckboxes = document.querySelector('.genres-checkboxes');

    let validerNouveauGenre = document.querySelector('#valider-nouveau-genre');
    let msgErreurGenre = document.querySelector('.erreur-genre');
    validerNouveauGenre.addEventListener('click', function() {

        let nouveauGenre = inputNouveauGenre.value;
        msgErreurGenre.style.display = "none";

        if (nouveauGenre !== '') {

            if (document.getElementById(nouveauGenre)) {
                msgErreurGenre.style.display = "block";
                return;
            }
            else { 
                let genreDiv = document.createElement('div');
                genreDiv.className = 'genre';

                let inputGenre = document.createElement('input');
                inputGenre.type = 'checkbox';
                inputGenre.name = 'genres[]';
                inputGenre.id = nouveauGenre;
                inputGenre.value = nouveauGenre;

                let labelGenre = document.createElement('label');
                labelGenre.htmlFor = nouveauGenre;
                labelGenre.textContent = nouveauGenre;

                genreDiv.appendChild(inputGenre);
                genreDiv.appendChild(labelGenre);

                classGenresCheckboxes.appendChild(genreDiv);

                inputNouveauGenre.value = '';
                divFormAjoutGenre.style.display = "none";
            }
        }
    });
});

    
