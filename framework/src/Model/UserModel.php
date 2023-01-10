<?php 

// Définition du namespace
namespace App\Model;

// Import des classes
use App\Core\AbstractModel;

class UserModel extends AbstractModel {

    function getUserByEmail(string $email): array 
    {
        // Préparation de la requête
        $sql = 'SELECT * FROM user WHERE email = ?';
        $pdoStatement = self::$pdo->prepare($sql);

        // Exécution de la requête
        $pdoStatement->execute([$email]);

        // Récupération du résultat 
        $user = $pdoStatement->fetch();

        if (!$user) {
            return [];
        }
        return $user;
    }

    /** 
     * Insère un utilisateur en base de données
     */
    function insertUser(string $firstname, string $lastname, string $email, string $password)
    {
        // Hashage du mot de passe
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Insertion des données 
        $sql = 'INSERT INTO user (firstname, lastname, email, password, createdAt)
                VALUES (?, ?, ?, ?, NOW())';

        $pdoStatement = self::$pdo->prepare($sql);
        $pdoStatement->execute([$firstname, $lastname, $email, $passwordHash]);
    }
}