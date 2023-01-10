<?php 

// Définition du namespace
namespace App\Model;

// Import des classes
use App\Core\AbstractModel;

class PriorityModel extends AbstractModel {

    /**
     * Sélectionne l'ensemble des priorités de la table priority
     * @return array Le tableau contenant les priorités
     */
    function getAllPriorities(): array
    {
        // Préparation de la requête
        $sql = 'SELECT * FROM priority';
        $pdoStatement = self::$pdo->prepare($sql);
        
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
}