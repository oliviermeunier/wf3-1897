

// FONCTIONS
function onSubmitForm(event)
{
    // Annuler le comportement par défaut du navigateur
    event.preventDefault();

    // @TODO valider les données côté client en JS

    // Récupérer les données du formulaire
    // La propriété currentTarget de l'objet event contient l'élément déclencheur de l'événement
    const form = event.currentTarget; // On récupère l'élément <form>
    const formData = new FormData(form); // On récupère les données (valeurs) du formulaire

    // On envoie ces données dans une requête HTTP AJAX via la fonction fetch()
    const url = 'sendMail.php';

    // On prépare les options de la requête 
    const options = {
        method: 'POST', // On envoie la requête avec la méthode HTTP POST
        body: formData // On transmet dans le corps de la requête les données du formulaire
    };

    // Envoi de la requête HTTP (AJAX)
    fetch(url, options)
        .then(function(response) {
            // On récupère la réponse HTTP et on en extrait les données du body (corps)
            return response.json();
        })
        .then(function(data) {
            // Ici je récupère les données renvoyées par le serveur dans la réponse HTTP
            
            // On efface les messages
            const container = document.getElementById('success-message');
            container.textContent = '';
            container.classList.add('hidden');

            const errorMessages = document.querySelectorAll('.error');
            for (const errorMessage of errorMessages) {
                errorMessage.remove(); // On supprimer l'élément du DOM
            }

            // En cas de succès
            if ("success" in data) {
                container.textContent = data.success;
                container.classList.remove('hidden');
            }
            // En cas d'erreur
            else if (data.hasOwnProperty("errors")) {

                // On parcours les propriétés de l'ojet data.errors (qui correspodnent aux noms des champs)
                // avec la boucle for...in
                for (const fieldName in data.errors) {
                    // A chaque tour de boucle, fieldName correspond à une propriété de l'objet data.errors
                    // Pour récupérer la valeur associée à une propriété de manière dynamique
                    // on utilise la syntaxe des tableaux associatifs objet[variable]
                    const error = data.errors[fieldName];

                    // Sélection du champ en erreur
                    const field = document.getElementById(fieldName);

                    // Construction du message d'erreur
                    const p = document.createElement('p');
                    p.classList.add('error');
                    p.textContent = error;

                    // Insertion du paragraphe d'erreur après le champ
                    field.after(p);
                }
            }
        });

}

// CODE PRINCIPAL
document.getElementById('contact-form').addEventListener('submit', onSubmitForm);