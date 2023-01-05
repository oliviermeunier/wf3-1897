<?php 

// Récupération et validation de l'id de la tâche de l'URL (chaîne de requête)
if (!array_key_exists('id', $_GET) || !ctype_digit($_GET['id'])) {
    echo 'Id de la tâche incorrect';
    exit;
}

// Ici je sais que j'ai bien mon paramètre id dans l'URL et que c'est un nombre
$taskId = $_GET['id'];

// Initialisations
$errors = []; // Tableau qui contiendra les erreurs

// Création de la date du jour
$today = date('Y-m-d');

// Sélection de la tâche à modifier dans la base de données à partir de son id
$task = getOneTaskById($taskId);

// la tâche existe-t-elle bien ?
if (!$task) {
    echo 'Tâche introuvable';
    exit;
}

// Variables qui vont permettre de pré remplir le formulaire
// avec les valeurs de la tâche à modifier
$title = $task['title'];
$description = $task['description'];
$priority = $task['priority_id'];
$deadline = $task['deadline'];
$isDone = 0;

// Si le formulaire est soumis...
if (!empty($_POST)) {

    // On récupère les données du formulaire
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $priority = $_POST['priority'];
    $deadline = !$_POST['deadline'] ? null : $_POST['deadline'];

    // Validation des données
    if (!$title) {
        $errors['title'] = 'Le champ "titre" est obligatoire';
    }

    /**
     * @TODO valider la priorité :  
     * - est-ce qu'on récupère un champ 'priority' ?
     * - est-ce que c'est un entier ? 
     * - est-ce que cet entier correspond bien à une priorité dans la BDD ?
     */ 

    if ($deadline != null && $deadline < $today) {
        $errors['deadline'] = 'La deadline doit être dans le futur';
    }

    // Si pas d'erreurs...
    if (empty($errors)) {

        // Insertion de la tâche en base de données
        editTask($title, $description, $deadline, $priority, $taskId);

        // Ajouter un message flash
        addFlash('La tâche a bien été modifiée.');

        // Redirection 
        header('Location: /');
        exit;
    }
}

// Sélection des priorités
$priorities = getAllPriorities();

// Affichage du formulaire : inclusion du fichier de template
$template = 'editTask';
include '../templates/base.phtml'; 