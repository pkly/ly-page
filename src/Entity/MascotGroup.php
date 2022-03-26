<?php

namespace App\Entity;

use App\Repository\MascotGroupRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MascotGroupRepository::class)]
class MascotGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $title;

    #[ORM\Column(type: Types::ARRAY)]
    private array $directories = [];

    #[ORM\Column(options: ['default' => false])]
    private ?bool $defaultGroup = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(
        string $title
    ): static {
        $this->title = $title;

        return $this;
    }

    public function getDirectories(): ?array
    {
        return $this->directories;
    }

    public function setDirectories(
        array $directories
    ): static {
        $this->directories = $directories;

        return $this;
    }

    public function getDefaultGroup(): ?bool
    {
        return $this->defaultGroup;
    }

    public function setDefaultGroup(
        bool $defaultGroup
    ): static {
        $this->defaultGroup = $defaultGroup;

        return $this;
    }
}
