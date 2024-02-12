<?php

namespace App\Entity;

use App\Repository\SubLinkBlockRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: SubLinkBlockRepository::class)]
class SubLinkBlock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int|null $id = null;

    #[ORM\ManyToOne(inversedBy: 'subLinkBlocks')]
    #[ORM\JoinColumn(nullable: false)]
    private LinkBlock|null $linkBlock = null;

    #[ORM\Column(length: 255)]
    #[Groups('api')]
    private string|null $url = null;

    #[ORM\Column(length: 255)]
    #[Groups('api')]
    private string|null $title = null;

    public function getId(): int|null
    {
        return $this->id;
    }

    public function getLinkBlock(): LinkBlock|null
    {
        return $this->linkBlock;
    }

    public function setLinkBlock(
        LinkBlock|null $linkBlock
    ): static {
        $this->linkBlock = $linkBlock;

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
