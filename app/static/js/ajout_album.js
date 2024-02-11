
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
// document.addEventListener("DOMContentLoaded", function() {
//     // Sélectionnez le bouton "Ajouter un genre"
//     const ajoutGenreBtn = document.getElementById('ajout-genre');

//     // Ajoutez un gestionnaire d'événement au clic sur le bouton
//     ajoutGenreBtn.addEventListener('click', function() {
//         // Créez un nouvel élément de champ de saisie de genre
//         const nouveauGenreInput = document.createElement('input');
//         nouveauGenreInput.type = 'text';
//         nouveauGenreInput.id = 'nouveauGenre';
//         nouveauGenreInput.name = 'nouveaux_genres[]'; // Utilisez un tableau pour les nouveaux genres
//         nouveauGenreInput.placeholder = 'Nouveau genre';

//         // Créez un nouvel élément de label pour le champ de saisie
//         const nouveauGenreLabel = document.createElement('label');
//         nouveauGenreLabel.textContent = 'Nouveau genre: ';

//         // Créer un formulaire pour le nouveau genre
//         const nouveauGenreForm = document.createElement('form');

//         // créer un bouton pour valider l'entrée du nouveau genre
//         const nouveauGenreSubmit = document.createElement('button');
//         nouveauGenreSubmit.id = 'validerNouveauGenre';
//         nouveauGenreSubmit.name = 'valider_nouveau_genre';
//         nouveauGenreSubmit.textContent = 'Valider';
//         nouveauGenreSubmit.type = 'submit';

//         // Ajouter un gestionnaire d'événement pour le clic sur le bouton "Valider"
//         nouveauGenreSubmit.addEventListener('click', function(event) {
//             event.preventDefault();

//             // Récupérer la valeur du champ de saisie du nouveau genre
//             var nouveauGenreValue = document.getElementById('nouveauGenre').value.trim();

//             // Effectuer les validations nécessaires
//             if (nouveauGenreValue !== '') {
//                 // Créer un objet FormData pour envoyer les données du formulaire
//                 var formData = new FormData();
//                 formData.append('nouveauGenre', nouveauGenreValue);

//                 // Envoyer les données via AJAX
//                 var xhr = new XMLHttpRequest();
//                 xhr.open('POST', '../../views/admin/ajout_album.php', true);
//                 xhr.send(formData);
//             } else {
//                 // Afficher un message d'erreur ou effectuer une autre action en cas de champ vide
//                 alert('Veuillez saisir un nouveau genre');
//             }
//         });

//         // Ajouter les éléments au formulaire
//         nouveauGenreForm.appendChild(nouveauGenreLabel);
//         nouveauGenreForm.appendChild(nouveauGenreInput);
//         nouveauGenreForm.appendChild(nouveauGenreSubmit);

//         // Sélectionnez le conteneur des genres existants
//         const genresCheckboxes = document.querySelector('.genres-checkboxes');

//         // Ajoutez le formulaire du nouveau genre à la liste des genres
//         genresCheckboxes.appendChild(nouveauGenreForm);


//         document.getElementById('validerNouveauGenre').addEventListener('click', function(event) {
//             // Empêcher l'envoi du formulaire principal
//             event.preventDefault();
//             console.log("Test");
    
//             // Récupérer la valeur du champ de saisie du nouveau genre
//             var nouveauGenreValue = document.getElementById('nouveauGenre').value.trim();
    
//             console.log(nouveauGenreValue);
//             // Effectuer les validations nécessaires
//             if (nouveauGenreValue !== '') {
//                 // Créer un objet FormData pour envoyer les données du formulaire
//                 var formData = new FormData();
//                 formData.append('nouveauGenre', nouveauGenreValue);
    
//                 // Envoyer les données via AJAX
//                 var xhr = new XMLHttpRequest();
                // xhr.open('POST', '../../views/admin/ajout_album.php', true);
//                 xhr.send(formData);
//                 console.log("REQUETE ENVOYEE");
//             } else {
//                 // Afficher un message d'erreur ou effectuer une autre action en cas de champ vide
//                 alert('Veuillez saisir un nouveau genre');
//             }
//         });
//     });
// });

    
