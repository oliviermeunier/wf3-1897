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

// Récupération du message flash le cas échéant
$flashMessage = fetchFlash();

// Affichage : inclusion du template
include 'index.phtml';
