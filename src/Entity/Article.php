<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=8, max=255)
     */
    private $article_titre;

    /**
     * @ORM\Column(type="string")
     *  @Assert\Length(min=10)
     */
    private $article_contenu;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url()
     */
    private $article_image;

    /**
     * @ORM\Column(type="datetime")
     */
    private $article_date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $article_valide;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="abonne_articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $abonne;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticleTitre(): ?string
    {
        return $this->article_titre;
    }

    public function setArticleTitre(string $article_titre): self
    {
        $this->article_titre = $article_titre;

        return $this;
    }

    public function getArticleContenu(): ?string
    {
        return $this->article_contenu;
    }

    public function setArticleContenu(string $article_contenu): self
    {
        $this->article_contenu = $article_contenu;

        return $this;
    }

    public function getArticleImage(): ?string
    {
        return $this->article_image;
    }

    public function setArticleImage(string $article_image): self
    {
        $this->article_image = $article_image;

        return $this;
    }

    public function getArticleDate(): ?\DateTimeInterface
    {
        return $this->article_date;
    }

    public function setArticleDate(\DateTimeInterface $article_date): self
    {
        $this->article_date = $article_date;

        return $this;
    }

    public function getArticleValide(): ?bool
    {
        return $this->article_valide;
    }

    public function setArticleValide(bool $article_valide): self
    {
        $this->article_valide = $article_valide;

        return $this;
    }

    public function getAbonne(): ?User
    {
        return $this->abonne;
    }

    public function setAbonne(?User $abonne): self
    {
        $this->abonne = $abonne;

        return $this;
    }
}

