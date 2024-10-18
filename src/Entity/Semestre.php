<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SemestreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SemestreRepository::class)]
#[ApiResource]
class Semestre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $parcours = null;

    #[ORM\Column]
    private ?int $ordre = null;

    /**
     * @var Collection<int, Matiere>
     */
    #[ORM\OneToMany(targetEntity: Matiere::class, mappedBy: 'semestre')]
    private Collection $matieres;

    #[ORM\Column]
    private ?int $sizeCm = null;

    #[ORM\Column(length: 255)]
    private ?string $listeGroupesTd = null;

    #[ORM\Column(length: 255)]
    private ?string $listeGroupesTp = null;

    /**
     * @var Collection<int, Edt>
     */
    #[ORM\OneToMany(targetEntity: Edt::class, mappedBy: 'semestre')]
    private Collection $edts;

    public function __construct()
    {
        $this->matieres = new ArrayCollection();
        $this->edts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getParcours(): ?string
    {
        return $this->parcours;
    }

    public function setParcours(?string $parcours): static
    {
        $this->parcours = $parcours;

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): static
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * @return Collection<int, Matiere>
     */
    public function getMatieres(): Collection
    {
        return $this->matieres;
    }

    public function addMatiere(Matiere $matiere): static
    {
        if (!$this->matieres->contains($matiere)) {
            $this->matieres->add($matiere);
            $matiere->setSemestre($this);
        }

        return $this;
    }

    public function removeMatiere(Matiere $matiere): static
    {
        if ($this->matieres->removeElement($matiere)) {
            // set the owning side to null (unless already changed)
            if ($matiere->getSemestre() === $this) {
                $matiere->setSemestre(null);
            }
        }

        return $this;
    }

    public function getSizeCm(): ?int
    {
        return $this->sizeCm;
    }

    public function setSizeCm(int $sizeCm): static
    {
        $this->sizeCm = $sizeCm;

        return $this;
    }

    public function getListeGroupesTd(): ?string
    {
        return $this->listeGroupesTd;
    }

    public function setListeGroupesTd(string $listeGroupesTd): static
    {
        $this->listeGroupesTd = $listeGroupesTd;

        return $this;
    }

    public function getListeGroupesTp(): ?string
    {
        return $this->listeGroupesTp;
    }

    public function setListeGroupesTp(string $listeGroupesTp): static
    {
        $this->listeGroupesTp = $listeGroupesTp;

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
            $edt->setSemestre($this);
        }

        return $this;
    }

    public function removeEdt(Edt $edt): static
    {
        if ($this->edts->removeElement($edt)) {
            // set the owning side to null (unless already changed)
            if ($edt->getSemestre() === $this) {
                $edt->setSemestre(null);
            }
        }

        return $this;
    }
}
