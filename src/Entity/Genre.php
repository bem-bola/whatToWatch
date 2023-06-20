<?php

namespace App\Entity;

use App\Repository\GenreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GenreRepository::class)
 */
class Genre
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
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=MovieSerie::class, mappedBy="genres")
     */
    private $movieSeries;

    public function __construct()
    {
        $this->movieSeries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|MovieSerie[]
     */
    public function getMovieSeries(): Collection
    {
        return $this->movieSeries;
    }

    public function addMovieSeries(MovieSerie $movieSeries): self
    {
        if (!$this->movieSeries->contains($movieSeries)) {
            $this->movieSeries[] = $movieSeries;
            $movieSeries->addGenre($this);
        }

        return $this;
    }

    public function removeMovieSeries(MovieSerie $movieSeries): self
    {
        if ($this->movieSeries->removeElement($movieSeries)) {
            $movieSeries->removeGenre($this);
        }

        return $this;
    }
}
