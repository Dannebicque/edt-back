<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProfesseurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfesseurRepository::class)]
#[ApiResource]
class Professeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 3)]
    private ?string $initiales = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $prenom = null;

    #[ORM\Column]
    private ?bool $vacataire = false;

    #[ORM\Column]
    private ?float $service = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInitiales(): ?string
    {
        return $this->initiales;
    }

    public function setInitiales(string $initiales): static
    {
        $this->initiales = $initiales;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function isVacataire(): ?bool
    {
        return $this->vacataire ?? false;
    }

    public function setVacataire(bool|string $vacataire): static
    {
        $this->vacataire = (bool)$vacataire;

        return $this;
    }

    public function getService(): ?float
    {
        return $this->service;
    }

    public function setService(string|float $service): static
    {
        $this->service = (float)$service;

        return $this;
    }
}
