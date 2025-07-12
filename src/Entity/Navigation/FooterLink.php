<?php

declare(strict_types=1);

namespace App\Entity\Navigation;

use App\Repository\Navigation\FooterLinkRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FooterLinkRepository::class)]
class FooterLink
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int|null $id = null;

    #[ORM\Column(length: 255)]
    private string|null $url = null;

    #[ORM\Column(length: 255)]
    private string|null $title = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private int|null $priority = 0;

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
