<?php

namespace App\Entity\Rss;

use App\Repository\Rss\ResultRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResultRepository::class)]
#[ORM\Table(name: 'rss__result')]
class Result
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $url;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $title;

    #[ORM\Column(type: Types::JSON)]
    private array $data = [];

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $seenAt;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $guid;

    #[ORM\ManyToOne]
    private ?Search $search;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(
        string $url
    ): self {
        $this->url = $url;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(
        string $title
    ): self {
        $this->title = $title;

        return $this;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function setData(
        array $data
    ): self {
        $this->data = $data;

        return $this;
    }

    public function getSeenAt(): ?\DateTimeImmutable
    {
        return $this->seenAt;
    }

    public function setSeenAt(
        ?\DateTimeImmutable $seenAt
    ): self {
        $this->seenAt = $seenAt;

        return $this;
    }

    public function getGuid(): ?string
    {
        return $this->guid;
    }

    public function setGuid(
        string $guid
    ): self {
        $this->guid = $guid;

        return $this;
    }

    public function getSearch(): ?Search
    {
        return $this->search;
    }

    public function setSearch(
        ?Search $search
    ): self {
        $this->search = $search;

        return $this;
    }
}
