<?php

namespace App\Entity;

use App\Repository\DetailCommandeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DetailCommandeRepository::class)
 */
class DetailCommande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantite;

    /**
     * @ORM\ManyToOne(targetEntity=Plat::class, inversedBy="detailCommandes")
     */
    private $fk_plat;

    /**
     * @ORM\ManyToOne(targetEntity=Commande::class, inversedBy="detailCommandes")
     */
    private $fk_commande;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(?int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getFkPlat(): ?Plat
    {
        return $this->fk_plat;
    }

    public function setFkPlat(?Plat $fk_plat): self
    {
        $this->fk_plat = $fk_plat;

        return $this;
    }

    public function getFkCommande(): ?Commande
    {
        return $this->fk_commande;
    }

    public function setFkCommande(?Commande $fk_commande): self
    {
        $this->fk_commande = $fk_commande;

        return $this;
    }
}
