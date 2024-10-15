<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EdtRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EdtRepository::class)]
#[ApiResource]
class Edt
{
    public const NON_PLACE = 'NON_PLACE';
    public const PLACE = 'PLACE';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $day = null;

    #[ORM\Column(length: 10)]
    private ?string $semestre = null;

    #[ORM\Column]
    private ?int $groupCount = null;

    #[ORM\Column]
    private ?int $groupIndex = null;

    #[ORM\Column(length: 10)]
    private ?string $matiere = null;

    #[ORM\Column(length: 5)]
    private ?string $professeur = null;

    #[ORM\Column(length: 5)]
    private ?string $time = null;

    #[ORM\Column]
    private ?int $week = null;

    #[ORM\Column(length: 7)]
    private ?string $color = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $room = null;

    #[ORM\Column(length: 10)]
    private ?string $flag = self::NON_PLACE;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): static
    {
        $this->day = $day;

        return $this;
    }

    public function getSemestre(): ?string
    {
        return $this->semestre;
    }

    public function setSemestre(string $semestre): static
    {
        $this->semestre = $semestre;

        return $this;
    }

    public function getGroupCount(): ?int
    {
        return $this->groupCount;
    }

    public function setGroupCount(int $groupCount): static
    {
        $this->groupCount = $groupCount;

        return $this;
    }

    public function getGroupIndex(): ?int
    {
        return $this->groupIndex;
    }

    public function setGroupIndex(int $groupIndex): static
    {
        $this->groupIndex = $groupIndex;

        return $this;
    }

    public function getMatiere(): ?string
    {
        return $this->matiere;
    }

    public function setMatiere(string $matiere): static
    {
        $this->matiere = $matiere;

        return $this;
    }

    public function getProfesseur(): ?string
    {
        return $this->professeur;
    }

    public function setProfesseur(string $professeur): static
    {
        $this->professeur = $professeur;

        return $this;
    }

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(string $time): static
    {
        $this->time = $time;

        return $this;
    }

    public function getWeek(): ?int
    {
        return $this->week;
    }

    public function setWeek(int $week): static
    {
        $this->week = $week;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'day' => $this->day,
            'group' => $this->semestre,
            'groupCount' => $this->groupCount,
            'groupIndex' => $this->groupIndex,
            'name' => $this->matiere,
            'professor' => $this->professeur,
            'time' => $this->time,
            'week' => $this->week,
            'room' => $this->room ?? 'A définir',
            'color' => $this->color,
            'blocked' => false,
        ];
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getRoom(): ?string
    {
        return $this->room;
    }

    public function setRoom(?string $room): static
    {
        $this->room = $room;

        return $this;
    }

    public function getFlag(): ?string
    {
        return $this->flag;
    }

    public function setFlag(string $flag): static
    {
        $this->flag = $flag;

        return $this;
    }
}
