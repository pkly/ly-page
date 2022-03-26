<?php

namespace App\Entity\Rss;

use App\Repository\Rss\GroupRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: 'rss__group')]
class Group
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id;

    #[ORM\Column(type: Types::STRING, length: 50)]
    private ?string $name;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $url;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(
        string $name
    ): static {
        $this->name = $name;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(
        string $url
    ): static {
        $this->url = $url;

        return $this;
    }

    #[Pure]
    public function __toString(): string
    {
        return $this->getName() ?? 'Unknown';
    }
}
