<?php

namespace App\Entity\Sayagym;

use App\Repository\Sayagym\PlanRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanRepository::class)]
class Plan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $rutina = null;

    #[ORM\Column(length: 255)]
    private ?string $enfoque = null;

    public function __construct($rutina = null, $enfoque = null) {
        $this->rutina = $rutina;
        $this->enfoque = $enfoque;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRutina(): ?string
    {
        return $this->rutina;
    }

    public function setRutina(string $rutina): static
    {
        $this->rutina = $rutina;

        return $this;
    }

    public function getEnfoque(): ?string
    {
        return $this->enfoque;
    }

    public function setEnfoque(string $enfoque): static
    {
        $this->enfoque = $enfoque;

        return $this;
    }
}