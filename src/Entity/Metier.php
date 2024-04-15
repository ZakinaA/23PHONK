<?php

namespace App\Entity;

use App\Repository\MetierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MetierRepository::class)]
class Metier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle = null;

    #[ORM\ManyToMany(targetEntity: Professionnel::class, inversedBy: 'metiers')]
    private Collection $profesionnel;

    public function __construct()
    {
        $this->profesionnel = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Professionnel>
     */
    public function getProfesionnel(): Collection
    {
        return $this->profesionnel;
    }

    public function addProfesionnel(Professionnel $profesionnel): static
    {
        if (!$this->profesionnel->contains($profesionnel)) {
            $this->profesionnel->add($profesionnel);
        }

        return $this;
    }

    public function removeProfesionnel(Professionnel $profesionnel): static
    {
        $this->profesionnel->removeElement($profesionnel);

        return $this;
    }
}
