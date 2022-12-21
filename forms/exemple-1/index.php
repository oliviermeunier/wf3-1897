<?php 

// Initialisation de la variable $firstname
$firstname = null;

// if (array_key_exists('firstname', $_GET)) { // est-ce que la clé 'firstname' existe dans le tableau $_GET
// if (isset($_GET['firstname'])) { // est-ce que la valeur $_GET['firstname'] est définie et non null
if (!empty($_GET)) { // si le tableau $_GET n'est pas vide...
    $firstname = $_GET['firstname'];
}

// Affichage
include 'index.phtml';