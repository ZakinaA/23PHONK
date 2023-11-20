<?php

namespace App\Entity;

use App\Repository\InstrumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InstrumentRepository::class)]
class Instrument
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numSene = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateAchat = null;

    #[ORM\Column(length: 255)]
    private ?string $prixAchat = null;

    #[ORM\Column(length: 255)]
    private ?string $utilisation = null;

    #[ORM\Column(length: 255)]
    private ?string $cheminimage = null;

    #[ORM\OneToMany(mappedBy: 'instrument', targetEntity: Contrat::class)]
    private Collection $contrats;

    public function __construct()
    {
        $this->contrats = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumSene(): ?string
    {
        return $this->numSene;
    }

    public function setNumSene(string $numSene): static
    {
        $this->numSene = $numSene;

        return $this;
    }

    public function getDateAchat(): ?\DateTimeInterface
    {
        return $this->dateAchat;
    }

    public function setDateAchat(\DateTimeInterface $dateAchat): static
    {
        $this->dateAchat = $dateAchat;

        return $this;
    }

    public function getPrixAchat(): ?string
    {
        return $this->prixAchat;
    }

    public function setPrixAchat(string $prixAchat): static
    {
        $this->prixAchat = $prixAchat;

        return $this;
    }

    public function getUtilisation(): ?string
    {
        return $this->utilisation;
    }

    public function setUtilisation(string $utilisation): static
    {
        $this->utilisation = $utilisation;

        return $this;
    }

    public function getCheminimage(): ?string
    {
        return $this->cheminimage;
    }

    public function setCheminimage(string $cheminimage): static
    {
        $this->cheminimage = $cheminimage;

        return $this;
    }

    public function getContrat(): ?Contrat
    {
        return $this->Contrat;
    }

    public function setContrat(?Contrat $Contrat): static
    {
        $this->Contrat = $Contrat;

        return $this;
    }

    /**
     * @return Collection<int, Contrat>
     */
    public function getContrats(): Collection
    {
        return $this->contrats;
    }

    public function addContrat(Contrat $contrat): static
    {
        if (!$this->contrats->contains($contrat)) {
            $this->contrats->add($contrat);
            $contrat->setInstrument($this);
        }

        return $this;
    }

    public function removeContrat(Contrat $contrat): static
    {
        if ($this->contrats->removeElement($contrat)) {
            // set the owning side to null (unless already changed)
            if ($contrat->getInstrument() === $this) {
                $contrat->setInstrument(null);
            }
        }

        return $this;
    }
}
