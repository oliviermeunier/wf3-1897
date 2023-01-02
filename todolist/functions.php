<?php 

function getPDOConnection(): PDO 
{
    // Connexion à la base de données avec PDO
    $dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';charset=utf8;port=3306';
    $user = DB_USER;
    $password = DB_PASS;
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Mode de gestion des erreurs SQL
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Mode de récupération des résultats par défaut : tableaux associatifs
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

    return $pdo;
}


/**
 * Sélectionne l'ensemble des priorités de la table priority
 */
function getAllPriorities(): array
{
    // Création d'une connexion PDO
    $pdo = getPDOConnection();

    // Préparation de la requête
    $sql = 'SELECT * FROM priority';
    $pdoStatement = $pdo->prepare($sql);
    
    // Exécution de la requête
    $pdoStatement->execute();

    // On retourne tous les résultats de la requête
    $results = $pdoStatement->fetchAll();

    // PHP < 8.0.0 : si on récupère la valeur false de la méthode fetchAll(), on retourne un tableau vide
    if (!$results) {
        return [];
    }

    return $results;
}

/**
 * Insert une nouvelle tâche dans la base de données
 */
function insertTask(string $title, string $description, int $isDone, string $deadline, int $priority): int
{
    // Création d'une connexion PDO
    $pdo = getPDOConnection();

    // Insertion des données dans la base de données
    $sql = 'INSERT INTO task 
    (title, description, createdAt, isDone, deadline, priority_id)
    VALUES (?,?,NOW(),?,?,?)';

    $pdoStatement = $pdo->prepare($sql);
    $pdoStatement->execute([$title, $description, $isDone, $deadline, $priority]);

    return $pdo->lastInsertId();
}