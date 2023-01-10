<?php 

namespace App\Entity;

class Priority {

    // Propriétés
    private ?int $id;
    private string $label;

    /**
     * Constructeur
     */
    public function __construct(?int $id, string $label)
    {
        $this->id = $id;
        $this->label = $label;
    }

    /**
     * Get the value of id
     */ 
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of label
     */ 
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Set the value of label
     *
     * @return  self
     */ 
    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }
}