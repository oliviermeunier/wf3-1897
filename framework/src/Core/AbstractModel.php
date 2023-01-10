<?php 

// Dans quel espace de nom (namespace) je travaille ?
// Chemin des dossiers : src/Core
namespace App\Core;

// Import des classes
use PDO;

/**
 * Je définie ma classe Model comme "abstraite" 
 * Je ne vais pas l'utiliser directement, on va pas créer d'objet Model
 * On ne fera jamais de $model = new Model();
 *  -> elle ne va servir qu'indirectement via d'autres classes qui vont en hériter
 */
abstract class AbstractModel {

    /**
     * Propriétés
     * Visibilité: 
     *    - public, j'accède à la propriété partout
     *    - private, j'accède à la propriété UNIQUEMENT dans la classe
     *    - protected, j'accède à la propriété dans la classe et dans ses enfants (les classes qui en héritent)
     * 
     * static : la propriété $pdo est commune à tous les objets de la 
     * classe AbstractModel
     */
    static protected ?PDO $pdo = null;

    /**
     * Propiété statique qui permet de compter le nombre d'instance de la classe AbstractModel 
     */
    private static int $count = 0;

    /**
     * Constructeur
     * Méthode "magique" appelée automatiquement lors de la création des objets
     * On s'en sert souvent pour initiliser des propriétés
     */
    function __construct()
    {
        if (self::$pdo == null) {

            // Appel de la méthode statique getPDOCOnnection directement sur la classe Database pour créer l'objet PDO
            self::$pdo = Database::getPDOConnection();

            // self fait référence à la classe courante
            // Tout ce qui est relatif aux classes, on utilise l'opérateur :: (opérateur de résolution de portée)
            self::$count++;
        }
    }

    /**
     * Méthode statique qui retourne la valeur de la propriété
     * statique $count
     */
    static function getCountPDO()
    {
        return self::$count;
    }
}