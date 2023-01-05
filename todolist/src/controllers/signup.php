<?php

// Initialisations
const PASSWORD_MIN_LENGTH = 8; // Longueur minimale du mot de passe

$errors = []; // Tableau qui contiendra les erreurs

$firstname = '';
$lastname = '';
$email = '';
$isSubscribed = false;

// Si le formulaire est soumis...
if (!empty($_POST)) {

    // 1. Récupération des champs du formulaire dans des variables
    $firstname = trim($_POST['firstname']); 
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $passwordConfirm = $_POST['password-confirm'];

    /**
     * La checkbox : 
     *   -> si elle est cochée, on récupère le contenu de l'attribut value du champ ou "on" si l'attribut value n'existe pas
     *   -> si elle n'est pas cochée, on ne récupère RIEN : il n'y a même pas la clé 'is-subscribed'
     * DONC je récupère simplement true ou false, en fonction de si $_POST['is-subscribed'] est défini ou non
     */
    $isSubscribed = isset($_POST['is-subscribed']); // $isSubscribed vaut true ou false

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

    if (getUserByEmail($email)) {
        $errors['email'] = 'Il existe déjà un compte associé à cette adresse email';
    }

    // Si aucune erreur... 
    if (empty($errors)) {

        // Connexion à la base de données
        $pdo = getPDOConnection();

        // Hashage du mot de passe
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Insertion des données 
        $sql = 'INSERT INTO user (firstname, lastname, email, password, isSubscribed, createdAt)
                VALUES (?, ?, ?, ?, ?, NOW())';

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute([$firstname, $lastname, $email, $passwordHash, $isSubscribed ? 1 : 0]);

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