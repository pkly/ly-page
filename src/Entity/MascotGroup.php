<?php

namespace App\Entity;

use App\Repository\MascotGroupRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MascotGroupRepository::class)
 */
class MascotGroup
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $title;

    /**
     * @ORM\Column(type="array")
     */
    private array $directories = [];

    /**
     * @ORM\Column(type="boolean", options={"default": 0})
     */
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
    ): self {
        $this->title = $title;

        return $this;
    }

    public function getDirectories(): ?array
    {
        return $this->directories;
    }

    public function setDirectories(
        array $directories
    ): self {
        $this->directories = $directories;

        return $this;
    }

    public function getDefaultGroup(): ?bool
    {
        return $this->defaultGroup;
    }

    public function setDefaultGroup(
        bool $defaultGroup
    ): self {
        $this->defaultGroup = $defaultGroup;

        return $this;
    }
}
