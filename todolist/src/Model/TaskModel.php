<?php 

// Définition du namespace
namespace App\Model;

// Import des classes
use App\Core\AbstractModel;
use App\Entity\Task;
use App\Entity\Priority;

// Définition de la classe TaskModel
class TaskModel extends AbstractModel {

    /**
     * Sélectionne la liste de toutes les tâches triées par deadline croissante
     * @return array Le tableau contenant toutes les tâches
     */
    function getAllTasks(): array 
    {
        // Préparation de la requête de sélection
        $sql = 'SELECT title, isDone, deadline, label AS priority, P.id AS priority_id, T.id AS task_id, createdAt, description 
                FROM task AS T
                INNER JOIN priority AS P
                ON T.priority_id = P.id
                ORDER BY deadline ASC';

        $pdoStatement = self::$pdo->prepare($sql);
        
        // Exécution de la requête
        $pdoStatement->execute();

        // Récupération et retour des résultats de la requête SQL
        $results = $pdoStatement->fetchAll();

        if (!$results) {
            return [];
        }

        ///////////////////////////////////////////////////////////////
        // Création des objets Task à partir du tableau de résultats

        // Création d'un tableau pour stocker les objets Task
        $tasks = [];

        // On parcours les résultats, pour chaque tâche (tableau associatif)...
        foreach ($results as $result) {

            // Création de l'objet Priority
            $priority = new Priority(
                $result['priority_id'],
                $result['priority']
            );

            // ... on instancie la classe Task
            $task = new Task(
                $result['task_id'],
                $result['title'],
                $result['description'],
                $result['createdAt'],
                $result['isDone'],
                $result['deadline'],
                $priority
            );

            // On ajoute l'objet Task dans le tableau de tâches
            $tasks[] = $task;
        }

        // On retourne le tableau de tâches
        return $tasks;
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
        // Insertion des données dans la base de données
        $sql = 'INSERT INTO task 
        (title, description, createdAt, isDone, deadline, priority_id)
        VALUES (?,?,NOW(),?,?,?)';

        $pdoStatement = self::$pdo->prepare($sql);
        $pdoStatement->execute([$title, $description, $isDone, $deadline, $priority]);

        return self::$pdo->lastInsertId();
    }

    /**
     * Supprime une tâche à partir de son id
     * @param int $taskId L'id de la tâche à supprimer
     */
    function deleteTask(int $taskId)
    {
        // Préparation de la requête SQL de suppression
        $sql = 'DELETE FROM task WHERE id = ?';

        $pdoStatement = self::$pdo->prepare($sql);
        
        // Exécution de la requête
        $pdoStatement->execute([$taskId]);
    }


    /**
     * Sélectionne une tâche à partir de son id
     * @param int $taskId L'id de la tâche que je souhaite sélectionner
     * @return array La tâche sélectionnée
     */
    function getOneTaskById(int $taskId): array
    {
        // Préparation de la requête de sélection
        $sql = 'SELECT title, description, deadline, priority_id 
                FROM task AS T
                WHERE T.id = ?';

        $pdoStatement = self::$pdo->prepare($sql);
        
        // Exécution de la requête
        $pdoStatement->execute([$taskId]);

        // Récupération et retour du résultat de la requête SQL
        $task = $pdoStatement->fetch();

        if (!$task) {
            return [];
        }

        return $task;
    }

    /**
     * Modifie une tâche existante dans la base de données
     * @param string $title Titre de la tâche
     * @param string $description Description de la tâche
     * @param string $deadline La date limite au format yyyy-mm-dd
     * @param int $priority L'id de la priorité de la tâche
     * @param int $taskId L'id de la tâche à modifier
     */
    function editTask(string $title, string $description, ?string $deadline, int $priority, int $taskId)
    {
        // Insertion des données dans la base de données
        $sql = 'UPDATE task 
                SET title = ?, description = ?, deadline = ?, priority_id = ?
                WHERE id = ?';

        $pdoStatement = self::$pdo->prepare($sql);
        $pdoStatement->execute([$title, $description, $deadline, $priority, $taskId]);
    }
}