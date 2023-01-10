<?php 

// Import de classes
use App\Model\PriorityModel;
use App\Model\TaskModel;

// Initialisations
$errors = []; // Tableau qui contiendra les erreurs

// Création de la date du jour
$today = date('Y-m-d');

// Variables qui vont permettre de réécrire les valeurs dans le formulaire
// en cas d'erreur de l'internaute
$title = '';
$description = '';
$priority = 1;
$deadline = $today;
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
        $taskModel = new TaskModel();
        $taskModel->insertTask($title, $description, $isDone, $deadline, $priority);

        // Ajouter un message flash
        addFlash('La tâche "'.$title.'" a bien été créée.');

        // Redirection 
        header('Location: /');
        exit;
    }
}

// Sélection des priorités
$priorityModel = new PriorityModel();
$priorities = $priorityModel->getAllPriorities();

// Affichage du formulaire : inclusion du fichier de template
$template = 'addTask';
include '../templates/base.phtml'; 