<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MatiereRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatiereRepository::class)]
#[ApiResource]
class Matiere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $code = null;

    #[ORM\Column]
    private ?int $nbCm = null;

    #[ORM\Column]
    private ?int $nbTd = null;

    #[ORM\Column]
    private ?int $nbTp = null;

    #[ORM\Column]
    private ?int $nbPtut = null;

    #[ORM\Column(length: 10)]
    private ?string $couleur = null;

    #[ORM\ManyToOne(inversedBy: 'matieres')]
    private ?Semestre $semestre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getNbCm(): ?int
    {
        return $this->nbCm;
    }

    public function setNbCm(int $nbCm): static
    {
        $this->nbCm = $nbCm;

        return $this;
    }

    public function getNbTd(): ?int
    {
        return $this->nbTd;
    }

    public function setNbTd(int $nbTd): static
    {
        $this->nbTd = $nbTd;

        return $this;
    }

    public function getNbTp(): ?int
    {
        return $this->nbTp;
    }

    public function setNbTp(int $nbTp): static
    {
        $this->nbTp = $nbTp;

        return $this;
    }

    public function getNbPtut(): ?int
    {
        return $this->nbPtut;
    }

    public function setNbPtut(int $nbPtut): static
    {
        $this->nbPtut = $nbPtut;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): static
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getSemestre(): ?Semestre
    {
        return $this->semestre;
    }

    public function setSemestre(?Semestre $semestre): static
    {
        $this->semestre = $semestre;

        return $this;
    }
}
