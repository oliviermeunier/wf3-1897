<?php 

/**
 * Crée une connexion à la base de données avec PDO
 * @return PDO l'objet PDO créé
 */
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
 * @return array Le tableau contenant les priorités
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
 * @param string $title Titre de la tâche
 * @param string $description Description de la tâche
 * @param int isDone 0 / 1 La tâche est-elle terminée ?
 * @param string $deadline La date limite au format yyyy-mm-dd
 * @param int $priority L'id de la priorité de la tâche
 */
function insertTask(string $title, string $description, int $isDone, ?string $deadline, int $priority): int
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


/**
 * Sélectionne la liste de toutes les tâches triées par deadline croissante
 * @return array Le tableau contenant toutes les tâches
 */
function getAllTasks(): array 
{
    // Création d'une connexion PDO
    $pdo = getPDOConnection();

    // Préparation de la requête de sélection
    $sql = 'SELECT title, isDone, deadline, label AS priority, P.id AS priority_id 
            FROM task AS T
            INNER JOIN priority AS P
            ON T.priority_id = P.id
            ORDER BY deadline ASC';

    $pdoStatement = $pdo->prepare($sql);
    
    // Exécution de la requête
    $pdoStatement->execute();

    // Récupération et retour des résultats de la requête SQL
    $tasks = $pdoStatement->fetchAll();

    if (!$tasks) {
        return [];
    }

    return $tasks;
}


/**
 * Détermine la classe CSS (bootstrap) de la priorité en fonction de son id
 * @param int $priorityId L'id de la priorité 
 * @return string La classe CSS correspondant à la priorité
 */
function getPriorityClass(int $priorityId): string
{
    // VERSION 1 avec des if
    // if ($priorityId == 1) {
    //     return 'bg-success';
    // }

    // if ($priorityId == 2) {
    //     return 'bg-warning';
    // }

    // if ($priorityId == 3) {
    //     return 'bg-danger';
    // }

    // Version 2 avec un switch
    // switch ($priorityId) {
    //     case 1:
    //         return 'bg-success';
        
    //     case 2:
    //         return 'bg-warning';

    //     case 3:
    //         return 'bg-danger';
    // }

    // Version 3 avec match ( > PHP 8.0)
    return match($priorityId) {
        1 => 'bg-success',
        2 => 'bg-warning',
        3 => 'bg-danger'
    };
}


/**
 * Détermine le statut d'une tâche :
 *  - terminée
 *  - en cours
 *  - en retard
 * @param array $task Le tableau associatif contenant les données de la tâche
 * @return string Le statut la tâche
 */
function getTaskStatus(array $task): string 
{
    // Si le champ isDone vaut 1 (équivalent à true)
    if ($task['isDone']) {
        return 'Terminée';
    }

    // Ici, je sais que isDone vaut 0
    
    // Si la deadline est dépassée (avant la date du jour)
    if ($task['deadline'] && $task['deadline'] < date('Y-m-d')) {
        return 'En retard';
    }

    // Ici je sais que la deadline n'est pas dépassée
    return 'En cours';
}

/**
 * Formatte une date au format "français"
 * @param null|string $date : date au format américain ('2023-05-12')
 * @return string La date formattée 
 */
function dateFormat(?string $date): string 
{
    // Si la date est null (pas de deadline)...
    if ($date == null) {

        // ... on retourne une chaîne vide
        return '';
    }

    // Création d'un objet DateTimeImmutable
    $objDate = new DateTimeImmutable($date);
    
    // Formattage de la date
    return $objDate->format('d/m/Y');
}

/**
 * Démarre la session si la session n'est pas déjà démarrée
 */
function initSession()
{
    // Si aucune session n'est démarrée pour le moment...
    if (session_status() == PHP_SESSION_NONE) {

        // ... on démarre la session
        session_start();
    }
}


/**
 * Ajoute un message en session
 * @param string $message Le message à ajouter en session
 */
function addFlash(string $message)
{
    initSession();

    $_SESSION['flashbag'] = $message;
}

/**
 * Détermine si il y a un message flash en session ou non
 * @return bool true s'il y a un message, false sinon
 */
function hasFlash(): bool
{
    initSession();

    return isset($_SESSION['flashbag']);
}

/**
 * Récupère le message flash de la session
 * @return null|string Le message flash ou null
 */
function fetchFlash(): ?string
{
    initSession();

    // Initialisation de la variable $flashMessage
    $flashMessage = null;

    // Récupération du message flash s'il existe
    if (hasFlash()) {
        
        // On récupère le message flash dans une variable
        $flashMessage = $_SESSION['flashbag'];

        // On efface le message de la session
        $_SESSION['flashbag'] = null;
    }

    return $flashMessage;
}