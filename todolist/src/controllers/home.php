<?php 

// Création d'un objet TaskModel
$taskModel = new TaskModel();

// Sélections de la liste des tâches
$tasks = $taskModel->getAllTasks();

// Récupération du message flash le cas échéant
$flashMessage = fetchFlash();

// Affichage : inclusion du template
$template = 'home';
include '../templates/base.phtml';
