<?php 

// On vérifie que la session est bien démarrée
initSession();

// On supprime les données de l'utilisateur en session
unset($_SESSION['user']);

// Détruire la session
session_destroy();

// Message flash
addFlash('Au revoir');

// Redirection 
header('Location: /');
exit;