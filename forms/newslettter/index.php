<?php 

$error = null;

// Si le formulaire a été soumis par l'internaute (si je reçois des données) ...
if (!empty($_POST)) {

    // 1. Récupérer les données du formulaire
    $email = $_POST['email'];

    // 2. Validation des données
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Adresse email invalide';
    }

    // 3. Enregistrement de l'email si pas d'erreur
    if ($error == null) {

        // Enregistrer l'email

    }

}






// Affichage : inclusion du template
include 'templates/index.phtml';