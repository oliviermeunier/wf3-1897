<?php 

// Inclusion des dépendances
require 'config.php';

// Traitements : sélectionner les 15 derniers produits

// Connexion à la base de données
$pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$pdo->exec('SET NAMES UTF8'); 

$sql = 'SELECT *
        FROM product
        ORDER BY created_at DESC
        LIMIT 15';

// Préparation de la requête SQL
$pdoStatement = $pdo->prepare($sql);

// Exécution
$pdoStatement->execute();

// Récupération des résultats
$products = $pdoStatement->fetchAll();

// Inclusion du fichier de template
include 'index.phtml';