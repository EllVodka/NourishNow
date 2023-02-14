<?php

namespace App\Entity;

use App\Repository\PlatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlatRepository::class)
 */
class Plat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tarif;

    /**
     * @ORM\ManyToOne(targetEntity=restaurant::class, inversedBy="plats")
     */
    private $fk_restaurant;

    /**
     * @ORM\OneToMany(targetEntity=DetailCommande::class, mappedBy="fk_plat")
     */
    private $detailCommandes;

    public function __construct()
    {
        $this->detailCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTarif(): ?float
    {
        return $this->tarif;
    }

    public function setTarif(?float $tarif): self
    {
        $this->tarif = $tarif;

        return $this;
    }

    public function getFkRestaurant(): ?restaurant
    {
        return $this->fk_restaurant;
    }

    public function setFkRestaurant(?restaurant $fk_restaurant): self
    {
        $this->fk_restaurant = $fk_restaurant;

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
            $detailCommande->setFkPlat($this);
        }

        return $this;
    }

    public function removeDetailCommande(DetailCommande $detailCommande): self
    {
        if ($this->detailCommandes->removeElement($detailCommande)) {
            // set the owning side to null (unless already changed)
            if ($detailCommande->getFkPlat() === $this) {
                $detailCommande->setFkPlat(null);
            }
        }

        return $this;
    }
}
