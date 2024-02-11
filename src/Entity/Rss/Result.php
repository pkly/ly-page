<?php

namespace App\Entity\Rss;

use App\Repository\Rss\ResultRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ResultRepository::class)]
#[ORM\Table(name: 'rss__result')]
class Result
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups('api')]
    private int|null $id;

    #[ORM\Column(type: Types::TEXT)]
    private string|null $url;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups('api')]
    private string|null $title;

    #[ORM\Column(type: Types::JSON)]
    private array $data = [];

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private \DateTimeImmutable|null $seenAt;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string|null $guid;

    #[ORM\ManyToOne]
    #[Groups('api')]
    private Search|null $search;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, options: ['default' => 'NOW()'])]
    #[Groups('api')]
    private \DateTimeImmutable|null $createdAt = null;

    public function getId(): int|null
    {
        return $this->id;
    }

    public function getUrl(): string|null
    {
        return $this->url;
    }

    public function setUrl(
        string $url
    ): self {
        $this->url = $url;

        return $this;
    }

    public function getTitle(): string|null
    {
        return $this->title;
    }

    public function setTitle(
        string $title
    ): self {
        $this->title = $title;

        return $this;
    }

    public function getData(): array|null
    {
        return $this->data;
    }

    public function setData(
        array $data
    ): self {
        $this->data = $data;

        return $this;
    }

    public function getSeenAt(): \DateTimeImmutable|null
    {
        return $this->seenAt;
    }

    public function setSeenAt(
        \DateTimeImmutable|null $seenAt
    ): self {
        $this->seenAt = $seenAt;

        return $this;
    }

    public function getGuid(): string|null
    {
        return $this->guid;
    }

    public function setGuid(
        string $guid
    ): self {
        $this->guid = $guid;

        return $this;
    }

    public function getSearch(): Search|null
    {
        return $this->search;
    }

    public function setSearch(
        Search|null $search
    ): self {
        $this->search = $search;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable|null
    {
        return $this->createdAt;
    }

    public function setCreatedAt(
        \DateTimeImmutable $createdAt
    ): static {
        $this->createdAt = $createdAt;

        return $this;
    }
}
