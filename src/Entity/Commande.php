<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $destination;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=personne::class, inversedBy="commandes")
     */
    private $fk_livreur;

    /**
     * @ORM\ManyToOne(targetEntity=personne::class, inversedBy="commandes")
     */
    private $fk_client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(?string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getFkLivreur(): ?personne
    {
        return $this->fk_livreur;
    }

    public function setFkLivreur(?personne $fk_livreur): self
    {
        $this->fk_livreur = $fk_livreur;

        return $this;
    }

    public function getFkClient(): ?personne
    {
        return $this->fk_client;
    }

    public function setFkClient(?personne $fk_client): self
    {
        $this->fk_client = $fk_client;

        return $this;
    }
}
