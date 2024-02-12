<?php

namespace App\Entity;

use App\Repository\FooterLinkRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: FooterLinkRepository::class)]
class FooterLink
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int|null $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('api')]
    private string|null $url = null;

    #[ORM\Column(length: 255)]
    #[Groups('api')]
    private string|null $title = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private int|null $priority = null;

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

    public function getPriority(): int|null
    {
        return $this->priority;
    }

    public function setPriority(
        int $priority
    ): static {
        $this->priority = $priority;

        return $this;
    }
}
