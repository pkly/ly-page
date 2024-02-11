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
    private int|null $id;

    #[ORM\Column(type: Types::STRING, length: 50)]
    private string|null $name;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string|null $url;

    #[Pure]
    public function __toString(): string
    {
        return $this->getName() ?? 'Unknown';
    }

    public function getId(): int|null
    {
        return $this->id;
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
}
