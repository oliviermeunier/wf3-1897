<?php 

// Récupération et validation de l'id de la tâche de l'URL (chaîne de requête)
if (!array_key_exists('id', $_GET) || !ctype_digit($_GET['id'])) {
    echo 'Id de la tâche incorrect';
    exit;
}

// Ici je sais que j'ai bien mon paramètre id dans l'URL et que c'est un nombre
$taskId = $_GET['id'];

// Sélection de la tâche à modifier dans la base de données à partir de son id
$task = getOneTaskById($taskId);

// la tâche existe-t-elle bien ?
if (!$task) {
    echo 'Tâche introuvable';
    exit;
}

// Suppression de la tâche
deleteTask($taskId);

// Message flash
addFlash('La tâche a bien été supprimée');

// Redirection
header('Location: /');
exit;
