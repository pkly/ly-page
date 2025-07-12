<?php

declare(strict_types=1);

namespace App\Entity\Rss;

use App\Repository\Rss\SearchRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SearchRepository::class)]
class Search
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int|null $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Source|null $source = null;

    #[ORM\Column(length: 1024)]
    private string|null $query = null;

    #[ORM\Column(length: 255)]
    private string|null $directory = null;

    #[ORM\Column]
    private bool|null $active = null;

    /**
     * @var Collection<int, Result>
     */
    #[ORM\OneToMany(targetEntity: Result::class, mappedBy: 'search', orphanRemoval: true)]
    private Collection $results;

    #[ORM\Column(nullable: true)]
    private \DateTime|null $lastSearchedAt = null;

    #[ORM\Column(nullable: true)]
    private \DateTime|null $lastFoundAt = null;

    public function __construct()
    {
        $this->results = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getQuery().' in '.$this->getSource()->getName();
    }

    public function getId(): int|null
    {
        return $this->id;
    }

    public function getSource(): Source|null
    {
        return $this->source;
    }

    public function setSource(
        Source|null $source
    ): static {
        $this->source = $source;

        return $this;
    }

    public function getQuery(): string|null
    {
        return $this->query;
    }

    public function setQuery(
        string $query
    ): static {
        $this->query = $query;

        return $this;
    }

    public function getDirectory(): string|null
    {
        return $this->directory;
    }

    public function setDirectory(
        string $directory
    ): static {
        $this->directory = $directory;

        return $this;
    }

    public function isActive(): bool|null
    {
        return $this->active;
    }

    public function setActive(
        bool $active
    ): static {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection<int, Result>
     */
    public function getResults(): Collection
    {
        return $this->results;
    }

    public function addResult(
        Result $result
    ): static {
        if (!$this->results->contains($result)) {
            $this->results->add($result);
            $result->setSearch($this);
        }

        return $this;
    }

    public function removeResult(
        Result $result
    ): static {
        if ($this->results->removeElement($result)) {
            // set the owning side to null (unless already changed)
            if ($result->getSearch() === $this) {
                $result->setSearch(null);
            }
        }

        return $this;
    }

    public function getLastSearchedAt(): \DateTime|null
    {
        return $this->lastSearchedAt;
    }

    public function setLastSearchedAt(
        \DateTime|null $lastSearchedAt
    ): static {
        $this->lastSearchedAt = $lastSearchedAt;

        return $this;
    }

    public function getLastFoundAt(): \DateTime|null
    {
        return $this->lastFoundAt;
    }

    public function setLastFoundAt(
        \DateTime|null $lastFoundAt
    ): static {
        $this->lastFoundAt = $lastFoundAt;

        return $this;
    }
}
