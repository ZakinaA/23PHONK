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


    #[ORM\Column(length: 20)]
    private ?string $numSerie = null;


    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateAchat = null;


    #[ORM\OneToMany(mappedBy: 'instrument', targetEntity: Contrat::class)]
    private Collection $contrats;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $prixAchat = null;

    #[ORM\Column(length: 20)]
    private ?string $utilisation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cheminImage = null;

    #[ORM\ManyToOne(inversedBy: 'instruments')]
    private ?TypeInstrument $type = null;

    #[ORM\ManyToOne(inversedBy: 'instruments')]
    private ?Marque $marque = null;

    #[ORM\OneToMany(mappedBy: 'instrument', targetEntity: Intervention::class)]
    private Collection $interventions;

    #[ORM\Column(length: 10)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'instrument', targetEntity: Accessoire::class)]
    private Collection $accessoires;

    public function __construct()
    {
        $this->interventions = new ArrayCollection();
        $this->accessoires = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }



    public function getNumSerie(): ?string
    {
        return $this->numSerie;
    }

    public function setNumSerie(string $numSerie): static
    {
        $this->numSerie = $numSerie;

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


    public function getCheminImage(): ?string
    {
        return $this->cheminImage;
    }

    public function setCheminImage(?string $cheminImage): static
    {
        $this->cheminImage = $cheminImage;

        return $this;
    }

    public function getType(): ?TypeInstrument
    {
        return $this->type;
    }

    public function setType(?TypeInstrument $type): static
    {
        $this->type = $type;


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
        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): static
    {
        $this->marque = $marque;


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

    /*
     * @return Collection<int, Intervention>
     */
    public function getInterventions(): Collection
    {
        return $this->interventions;
    }

    public function addIntervention(Intervention $intervention): static
    {
        if (!$this->interventions->contains($intervention)) {
            $this->interventions->add($intervention);
            $intervention->setInstrument($this);

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

                public
                function removeIntervention(Intervention $intervention): static
                {
                    if ($this->interventions->removeElement($intervention)) {
                        // set the owning side to null (unless already changed)
                        if ($intervention->getInstrument() === $this) {
                            $intervention->setInstrument(null);

                        }
                    }

                    return $this;

                }

                public function getName(): ?string
                {
                    return $this->name;
                }

                public function setName(string $name): static
                {
                    $this->name = $name;

                    return $this;
                }

                /**
                 * @return Collection<int, Accessoire>
                 */
                public function getAccessoires(): Collection
                {
                    return $this->accessoires;
                }

                public function addAccessoire(Accessoire $accessoire): static
                {
                    if (!$this->accessoires->contains($accessoire)) {
                        $this->accessoires->add($accessoire);
                        $accessoire->setInstrument($this);
                    }

                    return $this;
                }

                public function removeAccessoire(Accessoire $accessoire): static
                {
                    if ($this->accessoires->removeElement($accessoire)) {
                        // set the owning side to null (unless already changed)
                        if ($accessoire->getInstrument() === $this) {
                            $accessoire->setInstrument(null);
                        }
                    }

                    return $this;
                }
}


