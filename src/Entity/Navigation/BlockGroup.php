<?php

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
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
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

    public function addLink(BlockLink $link): static
    {
        if (!$this->links->contains($link)) {
            $this->links->add($link);
            $link->setBlock($this);
        }

        return $this;
    }

    public function removeLink(BlockLink $link): static
    {
        if ($this->links->removeElement($link)) {
            // set the owning side to null (unless already changed)
            if ($link->getBlock() === $this) {
                $link->setBlock(null);
            }
        }

        return $this;
    }
}
