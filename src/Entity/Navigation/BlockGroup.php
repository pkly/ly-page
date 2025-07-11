<?php

declare(strict_types=1);

namespace App\Entity\Navigation;

use App\Repository\Navigation\BlockGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BlockGroupRepository::class)]
class BlockGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int|null $id = null;

    #[ORM\Column(length: 255)]
    private string|null $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private string|null $description = null;

    /**
     * @var Collection<int, BlockLink>
     */
    #[ORM\OneToMany(targetEntity: BlockLink::class, mappedBy: 'block', orphanRemoval: true)]
    private Collection $links;

    public function __construct()
    {
        $this->links = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getTitle();
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
     * @return Collection<int, BlockLink>
     */
    public function getLinks(): Collection
    {
        return $this->links;
    }

    public function addLink(
        BlockLink $link
    ): static {
        if (!$this->links->contains($link)) {
            $this->links->add($link);
            $link->setBlock($this);
        }

        return $this;
    }

    public function removeLink(
        BlockLink $link
    ): static {
        if ($this->links->removeElement($link)) {
            // set the owning side to null (unless already changed)
            if ($link->getBlock() === $this) {
                $link->setBlock(null);
            }
        }

        return $this;
    }
}
