<?php 

// Inclusion de l'autoloader de composer
require 'vendor/autoload.php';

// Inclusion des dépendances
require 'config.php';
require 'functions.php';

// Sélections de la liste des tâches
$tasks = getAllTasks();

// Affichage : inclusion du template
include 'index.phtml';
