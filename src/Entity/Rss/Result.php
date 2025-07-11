<?php

declare(strict_types=1);

namespace App\Entity\Rss;

use App\Repository\Rss\ResultRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResultRepository::class)]
class Result
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int|null $id = null;

    #[ORM\Column(length: 2048)]
    private string|null $url = null;

    #[ORM\Column(length: 2048)]
    private string|null $title = null;

    #[ORM\Column]
    private array $data = [];

    #[ORM\Column(type: Types::GUID)]
    private string|null $guid = null;

    #[ORM\Column(nullable: true)]
    private \DateTimeImmutable|null $seenAt = null;

    #[ORM\ManyToOne(inversedBy: 'results')]
    #[ORM\JoinColumn(nullable: false)]
    private Search|null $search = null;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private \DateTimeImmutable|null $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

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
    ): static {
        $this->url = $url;

        return $this;
    }

    public function getTitle(): string|null
    {
        return $this->title;
    }

    public function setTitle(
        string $title
    ): static {
        $this->title = $title;

        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(
        array $data
    ): static {
        $this->data = $data;

        return $this;
    }

    public function getGuid(): string|null
    {
        return $this->guid;
    }

    public function setGuid(
        string $guid
    ): static {
        $this->guid = $guid;

        return $this;
    }

    public function getSeenAt(): \DateTimeImmutable|null
    {
        return $this->seenAt;
    }

    public function setSeenAt(
        \DateTimeImmutable|null $seenAt
    ): static {
        $this->seenAt = $seenAt;

        return $this;
    }

    public function getSearch(): Search|null
    {
        return $this->search;
    }

    public function setSearch(
        Search|null $search
    ): static {
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
