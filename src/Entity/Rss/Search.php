<?php

namespace App\Entity\Rss;

use App\Repository\Rss\SearchRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: SearchRepository::class)]
#[ORM\Table(name: 'rss__search')]
class Search
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private int|null $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string|null $query;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Group|null $rssGroup;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private string|null $directory;

    #[ORM\Column(options: ['default' => true])]
    private bool|null $active;

    #[Pure]
    public function __toString(): string
    {
        return $this->getQuery() ?? 'Unknown';
    }

    public function getId(): int|null
    {
        return $this->id;
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

    public function getRssGroup(): Group|null
    {
        return $this->rssGroup;
    }

    public function setRssGroup(
        Group|null $rssGroup
    ): static {
        $this->rssGroup = $rssGroup;

        return $this;
    }

    public function getDirectory(): string|null
    {
        return $this->directory;
    }

    public function setDirectory(
        string|null $directory
    ): static {
        $this->directory = $directory;

        return $this;
    }

    public function isActive(): bool|null
    {
        return $this->active;
    }

    public function setActive(
        bool|null $active
    ): static {
        $this->active = $active;

        return $this;
    }
}
