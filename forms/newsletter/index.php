<?php 

// Initialisations
const FILENAME = 'subscribers.json';
$error = null;

// Si le formulaire a été soumis par l'internaute (si je reçois des données) ...
if (!empty($_POST)) {

    // 1. Récupérer les données du formulaire
    $email = $_POST['email'];

    // 2. Validation des données
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Adresse email invalide';
    }

    //////////////////////////////////////////////
    // ETAPE #1 : on récupère le tableau d'abonnés

    // Initialisation du tableau d'abonnés
    $subscribers = [];

    // Récupération des abonnés existants
    if (file_exists(FILENAME)) {

        $jsonData = file_get_contents(FILENAME);

        // Désérialisation des données JSON
        $subscribers = json_decode($jsonData);
    }

    // Vérification de l'existance de l'email dans le tableau d'abonnés
    if (in_array($email, $subscribers)) {
        $error = 'Vous êtes déjà abonné à la newsletter !';
    }

    // 3. Enregistrement de l'email si pas d'erreur
    if ($error == null) {

        //////////////////////////////////////////////
        // ETAPE #2 : on ajoute le nouvel abonné
        
        // Ajout de l'email au tableau des abonnés
        $subscribers[] = $email;

        // Sérialisation du tableau d'abonnés au format JSON
        $jsonData = json_encode($subscribers);

        // Enregistrement du tableau d'abonnés dans le fichier JSON
        file_put_contents(FILENAME, $jsonData); // le fichier JSON est créé automatiquement s'il n'existe pas

        //////////////////////////////////////////////
        // ETAPE #3 : redirection de l'internaute
        // pour éviter l'envoi multiple du formulaire 
        // en cas de rafraichissement de la page par l'internaute
        header('Location: confirmation.html');
        exit;
    }

}

// Affichage : inclusion du template
include 'templates/index.phtml';