<?php

namespace App\Entity;

use App\Repository\SerieRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SerieRepository::class)
 */
class Serie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message = "Please provide a name")
     * @Assert\Length(
     *     min="2",
     *     max="255",
     *     minMessage="Minimum 2 characters",
     *     maxMessage="Maximum 255 characters"
     *     )
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     *@Assert\Length(
     *     min="2",
     *     max="3000",
     *     minMessage="Minimum 2 characters",
     *     maxMessage="Maximum 3000 characters")
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $overview;

    /**
     * @Assert\Choice(choices={"cancelled", "returning", "ended"})
     * @ORM\Column(type="string", length=50)
     */
    private $status;

    /**
     * @Assert\Type(type="float")
     * @Assert\Range(
     *     min="0",
     *     max="10",
     *     notInRangeMessage="Enter a mark between 0 and 10",
     * )
     * @ORM\Column(type="decimal", precision=3, scale=1, nullable=true)
     */
    private $vote;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2)
     */
    private $popularity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $genre;

    /**
     * @Assert\Type("DateTimeInterface")
     * @ORM\Column(type="date")
     */
    private $firstAirDate;

    /**
     * @Assert\Type("DateTimeInterface")
     * @Assert\GreaterThan(propertyPath="firstAirDate", message="Last air date cannot be prior to first air date")
     * @ORM\Column(type="date")
     */
    private $lastAirDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $backdrop;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $poster;

    /**
     * @ORM\Column(type="integer")
     */
    private $tmdbId;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateModified;

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

    public function getOverview(): ?string
    {
        return $this->overview;
    }

    public function setOverview(?string $overview): self
    {
        $this->overview = $overview;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getVote(): ?string
    {
        return $this->vote;
    }

    public function setVote(string $vote): self
    {
        $this->vote = $vote;

        return $this;
    }

    public function getPopularity(): ?string
    {
        return $this->popularity;
    }

    public function setPopularity(string $popularity): self
    {
        $this->popularity = $popularity;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getFirstAirDate(): ?\DateTimeInterface
    {
        return $this->firstAirDate;
    }

    public function setFirstAirDate(\DateTimeInterface $firstAirDate): self
    {
        $this->firstAirDate = $firstAirDate;

        return $this;
    }

    public function getLastAirDate(): ?\DateTimeInterface
    {
        return $this->lastAirDate;
    }

    public function setLastAirDate(\DateTimeInterface $lastAirDate): self
    {
        $this->lastAirDate = $lastAirDate;

        return $this;
    }

    public function getBackdrop(): ?string
    {
        return $this->backdrop;
    }

    public function setBackdrop(?string $backdrop): self
    {
        $this->backdrop = $backdrop;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(?string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getTmdbId(): ?int
    {
        return $this->tmdbId;
    }

    public function setTmdbId(int $tmdbId): self
    {
        $this->tmdbId = $tmdbId;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateModified(): ?\DateTimeInterface
    {
        return $this->dateModified;
    }

    public function setDateModified(?\DateTimeInterface $dateModified): self
    {
        $this->dateModified = $dateModified;

        return $this;
    }

}
