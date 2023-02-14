<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RestaurantRepository::class)
 */
class Restaurant
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lieu;

    /**
     * @ORM\ManyToOne(targetEntity=personne::class, inversedBy="restaurants")
     */
    private $fk_personne;

    /**
     * @ORM\ManyToOne(targetEntity=typeResto::class, inversedBy="restaurants")
     */
    private $fk_typeResto;

    /**
     * @ORM\ManyToOne(targetEntity=ville::class, inversedBy="restaurants")
     */
    private $fk_ville;

    /**
     * @ORM\OneToMany(targetEntity=Plat::class, mappedBy="fk_restaurant")
     */
    private $plats;

    public function __construct()
    {
        $this->plats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(?string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getFkPersonne(): ?personne
    {
        return $this->fk_personne;
    }

    public function setFkPersonne(?personne $fk_personne): self
    {
        $this->fk_personne = $fk_personne;

        return $this;
    }

    public function getFkTypeResto(): ?typeResto
    {
        return $this->fk_typeResto;
    }

    public function setFkTypeResto(?typeResto $fk_typeResto): self
    {
        $this->fk_typeResto = $fk_typeResto;

        return $this;
    }

    public function getFkVille(): ?ville
    {
        return $this->fk_ville;
    }

    public function setFkVille(?ville $fk_ville): self
    {
        $this->fk_ville = $fk_ville;

        return $this;
    }

    /**
     * @return Collection<int, Plat>
     */
    public function getPlats(): Collection
    {
        return $this->plats;
    }

    public function addPlat(Plat $plat): self
    {
        if (!$this->plats->contains($plat)) {
            $this->plats[] = $plat;
            $plat->setFkRestaurant($this);
        }

        return $this;
    }

    public function removePlat(Plat $plat): self
    {
        if ($this->plats->removeElement($plat)) {
            // set the owning side to null (unless already changed)
            if ($plat->getFkRestaurant() === $this) {
                $plat->setFkRestaurant(null);
            }
        }

        return $this;
    }
}
