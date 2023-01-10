<?php 

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



/**
 * Vérifie les identifiants de connexion et retourne les données 
 * de l'utilisateur si les identifiants sont corrects, 
 * un tableau vide sinon
 */
function checkCredentials($email, $password): array
{
    // 1°) Récupérer un utilisateur à partir de l'email
    $userModel = new App\Model\UserModel();
    $user = $userModel->getUserByEmail($email);

    // Si résultat vide => tableau vide
    if (!$user) {
        return [];
    }

    // 2°) Si l'email existe bien, on vérifie le mot de passe
    if (!password_verify($password, $user['password'])) {
        return [];
    }

    // Si on arrive ici, tout est OK
    return $user;
}

/**
 * Enregistre en session les données de l'utilisateur
 */
function registerUser(int $userId, string $email, string $firstname, string $lastname)
{
    // On s'assure que la session est bien démarrée
    initSession();

    $_SESSION['user'] = [
        'id' => $userId,
        'email' => $email,
        'firstname' => $firstname,
        'lastname' => $lastname
    ];
}

/**
 * Vérifie si l'utilisateur est connexté ou non
 */
function isConnected(): bool
{
    initSession();

    return array_key_exists('user', $_SESSION) && isset($_SESSION['user']);
}