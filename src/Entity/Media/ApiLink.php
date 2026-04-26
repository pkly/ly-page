<?php

declare(strict_types=1);

namespace App\Entity\Media;

use App\Repository\Media\ApiLinkRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApiLinkRepository::class)]
class ApiLink
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(options: ['unsigned' => true])]
    private int|null $id = null;

    #[ORM\Column(length: 255)]
    private string|null $userIdentifier = null;

    #[ORM\ManyToOne(inversedBy: 'apiLinks')]
    #[ORM\JoinColumn(nullable: false)]
    private MascotGroup|null $mascotGroup = null;

    public function getId(): int|null
    {
        return $this->id;
    }

    public function getUserIdentifier(): string|null
    {
        return $this->userIdentifier;
    }

    public function setUserIdentifier(
        string $userIdentifier
    ): static {
        $this->userIdentifier = $userIdentifier;

        return $this;
    }

    public function getMascotGroup(): MascotGroup|null
    {
        return $this->mascotGroup;
    }

    public function setMascotGroup(
        MascotGroup|null $mascotGroup
    ): static {
        $this->mascotGroup = $mascotGroup;

        return $this;
    }
}
