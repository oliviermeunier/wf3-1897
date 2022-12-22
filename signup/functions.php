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


function emailExists(string $email): bool 
{
    // Connexion à la base de données
    $pdo = getPDOConnection();

    // Préparation de la requête
    $sql = 'SELECT id FROM user WHERE email = ?';
    $pdoStatement = $pdo->prepare($sql);

    // Exécution de la requête
    $pdoStatement->execute([$email]);

    // Récupération du résultat 
    $user = $pdoStatement->fetch();

    if ($user) {
        return true;
    }
    return false;

    // return $user ? true : false;
}