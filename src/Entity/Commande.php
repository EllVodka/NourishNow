<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\ManyToOne(targetEntity=Personne::class, inversedBy="commandes")
     */
    private $fk_livreur;

    /**
     * @ORM\ManyToOne(targetEntity=Personne::class, inversedBy="commandes")
     */
    private $fk_client;

    /**
     * @ORM\OneToMany(targetEntity=DetailCommande::class, mappedBy="fk_commande")
     */
    private $detailCommandes;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class, inversedBy="commandes")
     */
    private $fk_status;

    public function __construct()
    {
        $this->detailCommandes = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->destination;
    }

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


    public function getFkLivreur(): ?Personne
    {
        return $this->fk_livreur;
    }

    public function setFkLivreur(?Personne $fk_livreur): self
    {
        $this->fk_livreur = $fk_livreur;

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

    /**
     * @return Collection<int, DetailCommande>
     */
    public function getDetailCommandes(): Collection
    {
        return $this->detailCommandes;
    }

    public function addDetailCommande(DetailCommande $detailCommande): self
    {
        if (!$this->detailCommandes->contains($detailCommande)) {
            $this->detailCommandes[] = $detailCommande;
            $detailCommande->setFkCommande($this);
        }

        return $this;
    }

    public function removeDetailCommande(DetailCommande $detailCommande): self
    {
        if ($this->detailCommandes->removeElement($detailCommande)) {
            // set the owning side to null (unless already changed)
            if ($detailCommande->getFkCommande() === $this) {
                $detailCommande->setFkCommande(null);
            }
        }

        return $this;
    }

    public function getFkStatus(): ?Status
    {
        return $this->fk_status;
    }

    public function setFkStatus(?Status $fk_status): self
    {
        $this->fk_status = $fk_status;

        return $this;
    }
}
