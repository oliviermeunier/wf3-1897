<?php 

// Inclusion de l'autoloader de composer
require 'vendor/autoload.php';

// Démarrage de la session
session_start();

// Inclusion des dépendances
require 'config.php';
require 'functions.php';

// Sélections de la liste des tâches
$tasks = getAllTasks();

// Initialisation de la variable $flashMessage
$flashMessage = null;

// Récupération du message flash s'il existe
if (isset($_SESSION['flashbag'])) {
    
    // On récupère le message flash dans une variable
    $flashMessage = $_SESSION['flashbag'];

    // On efface le message de la session
    $_SESSION['flashbag'] = null;
}

// Affichage : inclusion du template
include 'index.phtml';
