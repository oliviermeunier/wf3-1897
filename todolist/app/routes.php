<?php 

/**
 * On définit dans le tableau associatif $routes lal iste de nos routes.
 * Pour chaque route, on définit : 
 * - son nom 
 * - path (qui apparaît dans l'URL)
 * - controller : fichier à appeler 
 */

$routes = [

    // Page d'accueil
    'home' => [
        'path' => '/',
        'controller' => 'home.php'
    ],

    // Formulaire d'ajout d'une tâche
    'add-task' => [
        'path' => '/add-task',
        'controller' => 'addTask.php'
    ],

    // Formulaire de modification d'une tâche
    'edit-task' => [
        'path' => '/edit-task',
        'controller' => 'editTask.php'
    ],

    // Suppression d'une tâche
    'delete-task' => [
        'path' => '/delete-task',
        'controller' => 'deleteTask.php'
    ],

    // Création de compte
    'signup' => [
        'path' => '/signup',
        'controller' => 'signup.php'
    ],

    // Connexion utilisateur
    'login' => [
        'path' => '/login',
        'controller' => 'login.php'
    ],

    // Déconnexion
    'logout' => [
        'path' => '/logout',
        'controller' => 'logout.php'
    ],
];

return $routes;