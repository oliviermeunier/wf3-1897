<?php 

// Inclusion des dépendances
require 'config.php';

// Connexion à la base de données avec PDO
$dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';charset=utf8;port=3306';
$user = DB_USER;
$password = DB_PASS;
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // Mode de gestion des erreurs SQL
];

/**
 * J'entoure l'instruction new PDO() d'un bloc try car 
 * elle est susceptible de lancer une exception (erreur)
 */
try {
    $pdo = new PDO($dsn, $user, $password, $options);
}
catch(PDOException $exception) {
    
    // Ici en cas d'erreur, je récupère l'exception dans la variable $exception 
    // et je peux la traiter comme je veux !    
    echo 'ERREUR PDO : ' . $exception->getMessage();
    exit;
}

// Sélection des customers
$sql = 'SELECT customerName, phone, city 
        FROM customers
        ORDER BY customerName';

/** @var PDOStatement $pdoStatement */
$pdoStatement = $pdo->prepare($sql); // 1. préparation de la requête
$pdoStatement->execute(); // 2. Exécution de la requête
$customers = $pdoStatement->fetchAll(); // 3. Récupérer les résultats de la requête

/**
 * On prépare les requêtes pour se protéger des injections SQL
 * Il y a un risque lorsqu'on insère des données de l'utilisateur dans la requête
 * Si pas de risque on peut faire un query() à la place du prepare() et du execute()
 */
// $pdoStatement = $pdo->query($sql);

// Affichage : inclusion du fichier de template
include 'index.phtml';