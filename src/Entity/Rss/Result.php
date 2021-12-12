<?php

namespace App\Entity\Rss;

use App\Repository\Rss\ResultRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResultRepository::class)
 * @ORM\Table(name="rss__result")
 */
class Result
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $url;

    /**
     * @ORM\Column(type="text")
     */
    private $title;

    /**
     * @ORM\Column(type="json")
     */
    private $data = [];

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $seenAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $guid;

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
}
