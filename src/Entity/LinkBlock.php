<?php

namespace App\Entity;

use App\Repository\LinkBlockRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: LinkBlockRepository::class)]
class LinkBlock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int|null $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('api')]
    private string|null $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('api')]
    private string|null $description = null;

    #[ORM\OneToMany(targetEntity: SubLinkBlock::class, mappedBy: 'linkBlock', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[Groups('api')]
    private Collection $subLinkBlocks;

    public function __construct()
    {
        $this->subLinkBlocks = new ArrayCollection();
    }

    public function getId(): int|null
    {
        return $this->id;
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

    public function getDescription(): string|null
    {
        return $this->description;
    }

    public function setDescription(
        string|null $description
    ): static {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, SubLinkBlock>
     */
    public function getSubLinkBlocks(): Collection
    {
        return $this->subLinkBlocks;
    }

    public function addSubLinkBlock(
        SubLinkBlock $subLinkBlock
    ): static {
        if (!$this->subLinkBlocks->contains($subLinkBlock)) {
            $this->subLinkBlocks->add($subLinkBlock);
            $subLinkBlock->setLinkBlock($this);
        }

        return $this;
    }

    public function removeSubLinkBlock(
        SubLinkBlock $subLinkBlock
    ): static {
        if ($this->subLinkBlocks->removeElement($subLinkBlock)) {
            // set the owning side to null (unless already changed)
            if ($subLinkBlock->getLinkBlock() === $this) {
                $subLinkBlock->setLinkBlock(null);
            }
        }

        return $this;
    }
}
