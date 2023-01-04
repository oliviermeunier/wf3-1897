<?php 

// Sélections de la liste des tâches
$tasks = getAllTasks();

// Récupération du message flash le cas échéant
$flashMessage = fetchFlash();

// Affichage : inclusion du template
$template = 'home';
include '../templates/base.phtml';
