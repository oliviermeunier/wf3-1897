<?php 

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