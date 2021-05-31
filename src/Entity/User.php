<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * Assert\Email()
     */
    private $abonne_email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * Assert\Length(min="8", minMessage="Votre mot de passe doit faire minimum 8 caractères")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password",message="Les mots de passe ne correspondent pas")
     */
    public $confirm_password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $abonne_nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $abonne_prenom;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $abonne_image;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $abonne_tel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $abonne_region;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $abonne_description;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $abonne_username;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="abonne")
     */
    private $abonne_articles;

    /**
     * @ORM\OneToOne(targetEntity=Avis::class, mappedBy="abonne", cascade={"persist", "remove"})
     */
    private $abonne_avis;

    /**
     * @ORM\ManyToMany(targetEntity=Competence::class, mappedBy="abonne")
     */
    private $competences;


    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
        $this->abonne_articles = new ArrayCollection();
        $this->competences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAbonneEmail(): ?string
    {
        return $this->abonne_email;
    }

    public function setAbonneEmail($abonne_email): self
    {

        $this->abonne_email = $abonne_email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->abonne_username;
    }

    public function getAbonneUsername(): string
    {
        return (string) $this->abonne_username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getAbonneNom(): ?string
    {
        return $this->abonne_nom;
    }

    public function setAbonneNom(string $abonne_nom): self
    {
        $this->abonne_nom = $abonne_nom;

        return $this;
    }

    public function getAbonnePrenom(): ?string
    {
        return $this->abonne_prenom;
    }

    public function setAbonnePrenom(string $abonne_prenom): self
    {
        $this->abonne_prenom = $abonne_prenom;

        return $this;
    }

    public function getAbonneImage(): ?string
    {
        return $this->abonne_image;
    }

    public function setAbonneImage(string $abonne_image): self
    {
        $this->abonne_image = $abonne_image;

        return $this;
    }

    public function getAbonneTel(): ?string
    {
        return $this->abonne_tel;
    }

    public function setAbonneTel(string $abonne_tel): self
    {
        $this->abonne_tel = $abonne_tel;

        return $this;
    }

    public function getAbonneRegion(): ?string
    {
        return $this->abonne_region;
    }

    public function setAbonneRegion(string $abonne_region): self
    {
        $this->abonne_region = $abonne_region;

        return $this;
    }

    public function getAbonneDescription(): ?string
    {
        return $this->abonne_description;
    }

    public function setAbonneDescription(string $abonne_description): self
    {
        $this->abonne_description = $abonne_description;

        return $this;
    }

    public function setAbonneUserName(string $abonne_username): self
    {
        $this->abonne_username = $abonne_username;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setAbonne($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getAbonne() === $this) {
                $article->setAbonne(null);
            }
        }

        return $this;
    }

    public function getAbonneAvis(): ?Avis
    {
        return $this->abonne_avis;
    }

    public function setAbonneAvis(Avis $avis): self
    {
        // set the owning side of the relation if necessary
        if ($avis->getAbonne() !== $this) {
            $avis->setAbonne($this);
        }

        $this->abonne_avis = $avis;

        return $this;
    }

    /**
     * @return Collection|Competence[]
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->competences->contains($competence)) {
            $this->competences[] = $competence;
            $competence->addAbonne($this);
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        if ($this->competences->removeElement($competence)) {
            $competence->removeAbonne($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->abonne_username;
    }

}













    