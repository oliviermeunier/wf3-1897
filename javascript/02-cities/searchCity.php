<?php 

// Validation et récupération du paramètre city de l'URL
// if (!array_key_exists('city', $_GET)) {
//     $error = 'Le paramètre "city" est manquant dans l\'URL';
// }

// Récupération du paramètre city de l'URL 
$city = $_GET['city'];

// Inclusion des dépendances
require 'config.php';

// Traitements : sélectionner les 15 derniers produits

// Connexion à la base de données
$pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$pdo->exec('SET NAMES UTF8'); 

$sql = 'SELECT ville_nom_reel
        FROM villes_france_free
        WHERE ville_nom_reel LIKE ?
        ORDER BY ville_nom_reel ASC
        LIMIT 10';

// Préparation de la requête SQL
$pdoStatement = $pdo->prepare($sql);

// Exécution
$pdoStatement->execute([$city."%"]);

// Récupération des résultats
$results = $pdoStatement->fetchAll();

// On envoie les résultats de la requête SQL au format JSON
header('Content-Type: application/json; charset=utf-8');
echo json_encode($results);