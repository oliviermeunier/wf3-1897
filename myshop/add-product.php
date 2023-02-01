<?php 

// PAGE D'ACCUEIL

// Inclusion des dépendances
require 'config.php';

// Si le formulaire est soumis...
if (!empty($_POST)) {

    // 1. Récupération des données du formulaire
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $city = $_POST['city'];
    $postalCode = $_POST['postal-code'];

    // 2. Validation des données : est-ce que les données récupérées sont cohérentes ?
    
    // 3. Traitements 
    $price = $price *100;

    // 4. Si aucune erreur, on enregistre les données dans la base
    
    // Connexion à la base de données
    $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->exec('SET NAMES UTF8'); 

    // Préparer la requête SQL d'insertion (avec PDO préparer les requêtes et ne pas insérer de données directement dedans permet de se protéger des injections SQL
    $sql = 'INSERT INTO product 
            (title, description, price, city, postal_code, created_at) 
            VALUES (?,?,?,?,?, NOW())';

    $pdoStatement = $pdo->prepare($sql);
    $pdoStatement->execute([$title, $description, $price, $city, $postalCode]);

    // Redirection
    header('Location: index.php');
    exit;
}



// Définition des variables pour le template
$pageTitle = "Ajout d'un produit";


// Affichage : inclusion du fichier de template HTML
include 'add-product.phtml';