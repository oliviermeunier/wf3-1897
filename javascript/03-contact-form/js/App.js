export class App {

    // Constructeur de la classe App
    constructor() {

        // Création de propriétés
        this.form = document.getElementById('contact-form');
        this.container = document.getElementById('success-message');

        // Installation du gestionnaire d'événement sur le formulaire ("submit")
        this.form.addEventListener('submit', this.onSubmitForm.bind(this));
    }

    // Création d'un méthode onSubmitForm()
    async onSubmitForm(event) {

        // Annuler le comportement par défaut du navigateur
        event.preventDefault();

        // @TODO valider les données côté client en JS

        const data = await this.sendFormData();
                
        // On efface les messages si besoin
        this.resetMessages();                                

        // En cas de succès (l'objet data possède une propriété "success")
        if ("success" in data) {
            this.container.textContent = data.success;
            this.container.classList.remove('hidden');
        }
        // En cas d'erreur (l'objet data possède une propriété "errors")
        else if (data.hasOwnProperty("errors")) {

            this.showErrors(data.errors);                  
        }
    }

    async sendFormData() {

        const formData = new FormData(this.form); // On récupère les données (valeurs) du formulaire

        // On envoie ces données dans une requête HTTP AJAX via la fonction fetch()
        const url = 'sendMail.php';

        // On prépare les options de la requête 
        const options = {
            method: 'POST', // On envoie la requête avec la méthode HTTP POST
            body: formData // On transmet dans le corps de la requête les données du formulaire
        };

        // Envoi de la requête HTTP (AJAX)
        const response = await fetch(url, options);
        const data = await response.json(); 

        return data;
    }

    resetMessages() {

        // On efface les messages
        this.container.textContent = '';
        this.container.classList.add('hidden');

        const errorMessages = document.querySelectorAll('.error');
        for (const errorMessage of errorMessages) {
            errorMessage.remove(); // On supprimer l'élément du DOM
        }
    }

    showErrors(errors) {

        // On parcours les propriétés de l'ojet data.errors (qui correspodnent aux noms des champs)
        // avec la boucle for...in
        for (const fieldName in errors) {

            // A chaque tour de boucle, fieldName correspond à une propriété de l'objet data.errors
            // Pour récupérer la valeur associée à une propriété de manière dynamique
            // on utilise la syntaxe des tableaux associatifs objet[variable]
            const error = errors[fieldName];

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
}