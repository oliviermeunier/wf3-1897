<?php 

$error = null;

// Si le formulaire est soumis...
if(!empty($_POST)) {

    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérification des identifiants
    $user = checkCredentials($email, $password);

    // Si les identifiants sont incorrects
    if (!$user) {
        $error = 'Identifiants incorrects';
    } 
    // Sinon (les identifiants sont corrects)
    else {

        // On enregistre les données de l'utilisateur dans la session
        registerUser($user['id'], $user['email'], $user['firstname'], $user['lastname']);
    
        // Message flash
        addFlash('Connexion réussie !');

        // Redirection
        header('Location: /');
        exit;
    }
}

// Affichage : inclusion du template
$template = 'login';
include '../templates/base.phtml';