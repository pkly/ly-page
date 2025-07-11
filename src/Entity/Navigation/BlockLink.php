<?php

declare(strict_types=1);

namespace App\Entity\Navigation;

use App\Repository\Navigation\BlockLinkRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BlockLinkRepository::class)]
class BlockLink
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int|null $id = null;

    #[ORM\ManyToOne(inversedBy: 'links')]
    #[ORM\JoinColumn(nullable: false)]
    private BlockGroup|null $block = null;

    #[ORM\Column(length: 255)]
    private string|null $url = null;

    #[ORM\Column(length: 255)]
    private string|null $title = null;

    public function getId(): int|null
    {
        return $this->id;
    }

    public function getBlock(): BlockGroup|null
    {
        return $this->block;
    }

    public function setBlock(
        BlockGroup|null $block
    ): static {
        $this->block = $block;

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
}
