<?php

declare(strict_types=1);

namespace App\Entity\Rss;

use App\Repository\Rss\SourceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SourceRepository::class)]
class Source
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int|null $id = null;

    #[ORM\Column(length: 1024)]
    private string|null $url = null;

    #[ORM\Column(length: 255)]
    private string|null $name = null;

    public function __toString(): string
    {
        return $this->getName();
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

    public function getName(): string|null
    {
        return $this->name;
    }

    public function setName(
        string $name
    ): static {
        $this->name = $name;

        return $this;
    }
}
