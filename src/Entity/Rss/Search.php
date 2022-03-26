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
    private ?int $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $query;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Group $rssGroup;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $directory;

    #[ORM\Column(options: ['default' => true])]
    private ?bool $active;

    public function getId(): ?int {
        return $this->id;
    }

    public function getQuery(): ?string {
        return $this->query;
    }

    public function setQuery(
        string $query
    ): static {
        $this->query = $query;

        return $this;
    }

    public function getRssGroup(): ?Group {
        return $this->rssGroup;
    }

    public function setRssGroup(
        ?Group $rssGroup
    ): static {
        $this->rssGroup = $rssGroup;

        return $this;
    }

    public function getDirectory(): ?string {
        return $this->directory;
    }

    public function setDirectory(
        ?string $directory
    ): static {
        $this->directory = $directory;

        return $this;
    }

    public function isActive(): ?bool {
        return $this->active;
    }

    public function setActive(
        ?bool $active
    ): static {
        $this->active = $active;

        return $this;
    }

    #[Pure]
    public function __toString(): string {
        return $this->getQuery() ?? 'Unknown';
    }
}
