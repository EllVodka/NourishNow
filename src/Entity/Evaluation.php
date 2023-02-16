<?php

namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvaluationRepository::class)
 */
class Evaluation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity=Personne::class, inversedBy="evaluations")
     */
    private $fk_client;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurant::class, inversedBy="evaluations")
     */
    private $fk_restaurant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(?float $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getFkClient(): ?Personne
    {
        return $this->fk_client;
    }

    public function setFkClient(?Personne $fk_client): self
    {
        $this->fk_client = $fk_client;

        return $this;
    }

    public function getFkRestaurant(): ?Restaurant
    {
        return $this->fk_restaurant;
    }

    public function setFkRestaurant(?Restaurant $fk_restaurant): self
    {
        $this->fk_restaurant = $fk_restaurant;

        return $this;
    }
}
