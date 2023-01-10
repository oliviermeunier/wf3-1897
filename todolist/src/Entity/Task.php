<?php 

namespace App\Entity;

use App\Entity\Priority;

class Task {

    // VERSION PHP8 !! Si tous les types de données sont identiques
    // On déclare les propriétés directements dans les paramètres du constructeur
    // et PHP fait les affectations tout seul ! 
    //
    // public function __construct(
    //     private ?int $id,
    //     private string $title,
    //     private string $description,
    //     private \DateTimeImmutable $createdAt,
    //     private bool $isDone,
    //     private ?\DateTimeImmutable $deadline,
    //     private int $priorityId
    // ){
        
    // }

    // Propriétés
    private ?int $id;
    private string $title;
    private string $description;
    private \DateTimeImmutable $createdAt;
    private bool $isDone;
    private ?\DateTimeImmutable $deadline;
    private Priority $priority;

    /**
     * Constructeur
     */
    public function __construct(
        ?int $id,
        string $title,
        string $description,
        string $createdAt,
        bool $isDone,
        ?string $deadline,
        Priority $priority
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->createdAt = new \DateTimeImmutable($createdAt);
        $this->isDone = $isDone;
        $this->deadline = $deadline == null ? null : new \DateTimeImmutable($deadline);
        $this->priority = $priority;
    }


    /**
     * Détermine la classe CSS (bootstrap) de la priorité en fonction de son id
     * @param int $priorityId L'id de la priorité 
     * @return string La classe CSS correspondant à la priorité
     */
    function getPriorityClass(): string
    {
        return match($this->priority->getId()) {
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
     * @return string Le statut la tâche
     */
    function getStatus(): string 
    {
        // Si le champ isDone vaut 1 (équivalent à true)
        if ($this->isDone) {
            return 'Terminée';
        }

        // Ici, je sais que isDone vaut 0
        
        // Si la deadline est dépassée (avant la date du jour)
        if ($this->deadline && $this->deadline < date('Y-m-d')) {
            return 'En retard';
        }

        // Ici je sais que la deadline n'est pas dépassée
        return 'En cours';
    }


    /**
     * Formatte une date au format "français"
     * @return string La date formattée 
     */
    function getFormattedDeadline(): string 
    {
        // Si la date est null (pas de deadline)...
        if ($this->deadline == null) {

            // ... on retourne une chaîne vide
            return '';
        }
        
        // Formattage de la date
        return $this->deadline->format('d/m/Y');
    }


    /**
     * Getters et setters (accesseurs et mutateurs)
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of isDone
     */ 
    public function getIsDone(): bool
    {
        return $this->isDone;
    }

    /**
     * Set the value of isDone
     *
     * @return  self
     */ 
    public function setIsDone(bool $isDone): self
    {
        $this->isDone = $isDone;

        return $this;
    }

    /**
     * Get the value of deadline
     */ 
    public function getDeadline(): ?\DateTimeImmutable
    {
        return $this->deadline;
    }

    /**
     * Set the value of deadline
     *
     * @return  self
     */ 
    public function setDeadline(?\DateTimeImmutable $deadline): self
    {
        $this->deadline = $deadline;

        return $this;
    }

    /**
     * Get the value of priority
     */ 
    public function getPriority(): Priority
    {
        return $this->priority;
    }

    /**
     * Set the value of priority
     *
     * @return  self
     */ 
    public function setPriority(Priority $priority): self
    {
        $this->priority = $priority;

        return $this;
    }
}
