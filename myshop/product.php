<?php 

require 'config.php';

// Récupération de l'id du produit dans l'URL
if (!array_key_exists('id', $_GET) || !ctype_digit($_GET['id'])) {
    echo 'ERREUR : id incorrect';
    exit;
}

$productId = $_GET['id'];

// Sélection des données du produit dans la base de données

// Connexion à la base de données
$pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$pdo->exec('SET NAMES UTF8'); 

$sql = 'SELECT *
        FROM product
        WHERE id_product = ?';

// Préparation de la requête SQL
$pdoStatement = $pdo->prepare($sql);

// Exécution
$pdoStatement->execute([$productId]);

// Récupération du produit
$product = $pdoStatement->fetch();

// Si jamais on ne récupère pas de produit => erreur 404
if (!$product) {
    http_response_code(404);
    echo 'ERREUR : produit introuvable';
    exit;
}

// Traitement des données du formulaire de réservation
if(!empty($_POST)) {

    $message = $_POST['message'];

    $sql = 'UPDATE product 
            SET reservation_text = ?
            WHERE id_product = ?';

    // Préparation de la requête SQL
    $pdoStatement = $pdo->prepare($sql);

    // Exécution
    $pdoStatement->execute([$message, $productId]);    

    // Redirection
    header('Location: product.php?id=' . $productId);
    exit;
}


// Inclusion du template
include 'product.phtml';