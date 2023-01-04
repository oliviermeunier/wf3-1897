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
    ]
];

return $routes;