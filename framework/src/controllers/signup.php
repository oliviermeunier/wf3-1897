<?php

// Import de classes
use App\Model\UserModel;

// Initialisations
const PASSWORD_MIN_LENGTH = 8; // Longueur minimale du mot de passe

$errors = []; // Tableau qui contiendra les erreurs

$firstname = '';
$lastname = '';
$email = '';

// Si le formulaire est soumis...
if (!empty($_POST)) {

    // 1. Récupération des champs du formulaire dans des variables
    $firstname = trim($_POST['firstname']); 
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $passwordConfirm = $_POST['password-confirm'];

    // 2. Validation des données du formulaire
    if (!$firstname) {
        $errors['firstname'] = 'Le champ "Prénom" est obligatoire';
    }

    if (!$lastname) {
        $errors['lastname'] = 'Le champ "Nom" est obligatoire';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Le champ "email" n\'est pas valide';
    }

    if (strlen($password) < PASSWORD_MIN_LENGTH) {
        $errors['password'] = 'Le mot de passe doit contenir au moins 8 caractères';
    }

    if ($password != $passwordConfirm) {
        $errors['password-confirm'] = 'La confirmation du mot de passe doit ne correspond pas';
    }

    $userModel = new UserModel();
    if ($userModel->getUserByEmail($email)) {
        $errors['email'] = 'Il existe déjà un compte associé à cette adresse email';
    }

    // Si aucune erreur... 
    if (empty($errors)) {

        // Insertion de l'utilisateur en base de données
        $userModel->insertUser($firstname, $lastname, $email, $password);

        // Message flash
        addFlash('Votre compte a bien été créé').

        // Redirection
        header('Location: /');
        exit;
    }
}

// Affichage : inclusion du template
$template = 'signup';
include '../templates/base.phtml';