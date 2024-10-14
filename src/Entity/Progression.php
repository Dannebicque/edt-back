<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProgressionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgressionRepository::class)]
#[ApiResource]
class Progression
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $matiere = null;

    #[ORM\Column(length: 3)]
    private ?string $professeur = null;

    #[ORM\Column]
    private ?int $nbCm = 0;

    #[ORM\Column]
    private ?int $nbTd = 0;

    #[ORM\Column]
    private ?int $nbTp = 0;

    #[ORM\Column(nullable: true)]
    private ?int $nbPtut = 0;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $grTd = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $grTp = null;

    #[ORM\Column(nullable: true)]
    private ?array $progression = null;



    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatiere(): ?string
    {
        return $this->matiere;
    }

    public function setMatiere(?string $matiere = ''): static
    {
        $this->matiere = $matiere;

        return $this;
    }

    public function getProfesseur(): ?string
    {
        return $this->professeur;
    }

    public function setProfesseur(?string $professeur = ''): static
    {
        $this->professeur = $professeur;

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

    public function setNbPtut(?int $nbPtut): static
    {
        $this->nbPtut = $nbPtut;

        return $this;
    }

    public function getGrTd(): ?string
    {
        return $this->grTd;
    }

    public function setGrTd(?string $grTd): static
    {
        $this->grTd = $grTd;

        return $this;
    }

    public function getGrTp(): ?string
    {
        return $this->grTp;
    }

    public function setGrTp(?string $grTp): static
    {
        $this->grTp = $grTp;

        return $this;
    }

    public function getProgression(): ?array
    {
        return $this->progression ?? [];
    }

    public function setProgression(?array $progression): static
    {
        $this->progression = $progression;

        return $this;
    }
}
