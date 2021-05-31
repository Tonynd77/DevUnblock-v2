<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AvisRepository::class)
 */
class Avis
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)x
     */
    private $avis_titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $avis_contenu;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $avis_image;

    /**
     * @ORM\Column(type="datetime")
     */
    private $avis_date;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="abonne_avis", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $abonne;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAvisTitre(): ?string
    {
        return $this->avis_titre;
    }

    public function setAvisTitre(string $avis_titre): self
    {
        $this->avis_titre = $avis_titre;

        return $this;
    }

    public function getAvisContenu(): ?string
    {
        return $this->avis_contenu;
    }

    public function setAvisContenu(string $avis_contenu): self
    {
        $this->avis_contenu = $avis_contenu;

        return $this;
    }

    public function getAvisImage(): ?string
    {
        return $this->avis_image;
    }

    public function setAvisImage(string $avis_image): self
    {
        $this->avis_image = $avis_image;

        return $this;
    }

    public function getAvisDate(): ?\DateTimeInterface
    {
        return $this->avis_date;
    }

    public function setAvisDate(\DateTimeInterface $avis_date): self
    {
        $this->avis_date = $avis_date;

        return $this;
    }

    public function getAbonne(): ?User
    {
        return $this->abonne;
    }

    public function setAbonne(User $abonne): self
    {
        $this->abonne = $abonne;

        return $this;
    }
}
