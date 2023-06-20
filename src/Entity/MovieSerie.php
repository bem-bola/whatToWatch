<?php

namespace App\Entity;

use App\Repository\MovieSerieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MovieSerieRepository::class)
 */
class MovieSerie
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $origine;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img_affiche;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img_header;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $realisateur;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_sortieAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $acteur;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbSaison;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $plateforme;

    /**
     * @ORM\Column(type="text")
     */
    private $bande_annonce;

    /**
     * @ORM\Column(type="text")
     */
    private $lien_redirection;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity=Genre::class, inversedBy="movieSeries")
     */
    private $genres;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="favoris")
     * @ORM\JoinTable(name="user_film_favoris",
     *      joinColumns={@ORM\JoinColumn(name="movie_serie_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", unique=true)}
     * )
     */
    private $userFavoris;


    public function __construct()
    {
        $this->genres = new ArrayCollection();
        $this->userFavoris = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getOrigine(): ?string
    {
        return $this->origine;
    }

    public function setOrigine(string $origine): self
    {
        $this->origine = $origine;

        return $this;
    }

    public function getImgAffiche(): ?string
    {
        return $this->img_affiche;
    }

    public function setImgAffiche(string $img_affiche): self
    {
        $this->img_affiche = $img_affiche;

        return $this;
    }

    public function getImgHeader(): ?string
    {
        return $this->img_header;
    }

    public function setImgHeader(string $img_header): self
    {
        $this->img_header = $img_header;

        return $this;
    }

    public function getRealisateur(): ?string
    {
        return $this->realisateur;
    }

    public function setRealisateur(string $realisateur): self
    {
        $this->realisateur = $realisateur;

        return $this;
    }

    public function getDateSortieAt(): ?\DateTimeInterface
    {
        return $this->date_sortieAt;
    }

    public function setDateSortieAt(\DateTimeInterface $date_sortieAt): self
    {
        $this->date_sortieAt = $date_sortieAt;

        return $this;
    }

    public function getActeur(): ?string
    {
        return $this->acteur;
    }

    public function setActeur(string $acteur): self
    {
        $this->acteur = $acteur;

        return $this;
    }

    public function getNbSaison(): ?int
    {
        return $this->nbSaison;
    }

    public function setNbSaison(?int $nbSaison): self
    {
        $this->nbSaison = $nbSaison;

        return $this;
    }

    public function getPlateforme(): ?string
    {
        return $this->plateforme;
    }

    public function setPlateforme(string $plateforme): self
    {
        $this->plateforme = $plateforme;

        return $this;
    }

    public function getBandeAnnonce(): ?string
    {
        return $this->bande_annonce;
    }

    public function setBandeAnnonce(string $bande_annonce): self
    {
        $this->bande_annonce = $bande_annonce;

        return $this;
    }

    public function getLienRedirection(): ?string
    {
        return $this->lien_redirection;
    }

    public function setLienRedirection(string $lien_redirection): self
    {
        $this->lien_redirection = $lien_redirection;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Genre[]
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(Genre $genre): self
    {
        if (!$this->genres->contains($genre)) {
            $this->genres[] = $genre;
        }

        return $this;
    }

    public function removeGenre(Genre $genre): self
    {
        $this->genres->removeElement($genre);

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserFavoris(): Collection
    {
        return $this->userFavoris;
    }

    public function addUserFavori(User $userFavori): self
    {
        if (!$this->userFavoris->contains($userFavori)) {
            $this->userFavoris[] = $userFavori;
            $userFavori->addFavori($this);
        }

        return $this;
    }

    public function removeUserFavori(User $userFavori): self
    {
        if ($this->userFavoris->removeElement($userFavori)) {
            $userFavori->removeFavori($this);
        }

        return $this;
    }
}
