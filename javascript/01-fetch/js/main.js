


// FONCTIONS

/**
 * Réagit à la soumission du formulaire
 * @param {SubmitEvent} event 
 */
function onSubmitForm(event)
{
    /**
     * Annuler le comportement par défaut du navigateur
     * pour éviter que le formulaire ne se soumette (et qu'on change de page)
     */ 
    event.preventDefault();

    // On récupère la valeur de la liste déroulante (nombre de paragraphes)
    const paras = document.getElementById('paras').value;

    // On envoie la requête AJAX (HTTP) avec la fonction fetch() de JavaScript
    getParagraphs(paras)
        .then(displayParagraphs);
}

/**
 * Interroge l'API Bacon Ipsum 
 * @param {number} paras Le nombre de paragraphes souhaité
 * @returns {Promise} La promesse contenant les paragraphes
 */
function getParagraphs(paras)
{
    // Construire l'URL de l'API à interroger
    const url = `https://baconipsum.com/api/?type=all-meat&paras=${paras}`;

    // Je retourne la promesse retournée par le .then() qui contient 
    // le résultat de l'opération response.json()
    return fetch(url)
        .then(function(response) {
            // On extrait les données du corps (body) de la réponse HTTP au format JSON
            return response.json();
        });
}

/**
 * Affiche dans le DOM les paragraphes contenus dans le tableau paragraphs
 * @param {Array} paragraphs 
 */
function displayParagraphs(paragraphs) {

    // Ici on récupère les données parsées, on les affiche sur la page
    const container = document.getElementById('paras-container');
    container.innerHTML = ''; // On vide la section

    // On boucle sur le tableau de paragraphes...
    for (const para of paragraphs) {

        // On construit un nouvel élément <p> avec le texte du paragraphe dedans
        const p = document.createElement('p');
        p.textContent = para;

        // On ajoute le paragraphe courant après le contenu existant du container
        container.append(p);
    }
}


// CODE PRINCIPAL
const form = document.getElementById('bacon-form');
form.addEventListener('submit', onSubmitForm);