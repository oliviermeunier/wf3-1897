<?php 

/**
 * Vérifie si un email existe dans le tableau d'abonnés
 * @param string $email L'email à vérifier
 * @param array $subscribers Le tableau d'abonnés
 * @return bool true si l'email existe dans le tableau, false sinon
 */
function emailExists(string $email, array $subscribers): bool 
{
    return in_array($email, $subscribers);
}