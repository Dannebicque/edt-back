<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MatiereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private ?int $nbCm = 0;

    #[ORM\Column]
    private ?int $nbTd = 0;

    #[ORM\Column]
    private ?int $nbTp = 0;

    #[ORM\Column]
    private ?int $nbPtut = 0;

    #[ORM\Column(length: 10)]
    private ?string $couleur = null;

    #[ORM\ManyToOne(inversedBy: 'matieres')]
    private ?Semestre $semestre = null;

    /**
     * @var Collection<int, Progression>
     */
    #[ORM\OneToMany(targetEntity: Progression::class, mappedBy: 'matiere')]
    private Collection $progressions;

    /**
     * @var Collection<int, Edt>
     */
    #[ORM\OneToMany(targetEntity: Edt::class, mappedBy: 'matiere')]
    private Collection $edts;

    public function __construct()
    {
        $this->progressions = new ArrayCollection();
        $this->edts = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Progression>
     */
    public function getProgressions(): Collection
    {
        return $this->progressions;
    }

    public function addProgression(Progression $progression): static
    {
        if (!$this->progressions->contains($progression)) {
            $this->progressions->add($progression);
            $progression->setMatiere($this);
        }

        return $this;
    }

    public function removeProgression(Progression $progression): static
    {
        if ($this->progressions->removeElement($progression)) {
            // set the owning side to null (unless already changed)
            if ($progression->getMatiere() === $this) {
                $progression->setMatiere(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Edt>
     */
    public function getEdts(): Collection
    {
        return $this->edts;
    }

    public function addEdt(Edt $edt): static
    {
        if (!$this->edts->contains($edt)) {
            $this->edts->add($edt);
            $edt->setMatiere($this);
        }

        return $this;
    }

    public function removeEdt(Edt $edt): static
    {
        if ($this->edts->removeElement($edt)) {
            // set the owning side to null (unless already changed)
            if ($edt->getMatiere() === $this) {
                $edt->setMatiere(null);
            }
        }

        return $this;
    }
}
