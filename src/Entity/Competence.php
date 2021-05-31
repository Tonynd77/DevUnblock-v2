<?php

namespace App\Entity;

use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompetenceRepository::class)
 */
class Competence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $competence_nom;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="competences")
     */
    private $abonne;


    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->abonne = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompetenceNom(): ?string
    {
        return $this->competence_nom;
    }

    public function setCompetenceNom(string $competence_nom): self
    {
        $this->competence_nom = $competence_nom;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getAbonne(): Collection
    {
        return $this->abonne;
    }

    public function addAbonne(User $abonne): self
    {
        if (!$this->abonne->contains($abonne)) {
            $this->abonne[] = $abonne;
        }

        return $this;
    }

    public function removeAbonne(User $abonne): self
    {
        $this->abonne->removeElement($abonne);

        return $this;
    }

}
