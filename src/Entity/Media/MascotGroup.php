<?php

declare(strict_types=1);

namespace App\Entity\Media;

use App\Repository\Media\MascotGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MascotGroupRepository::class)]
class MascotGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int|null $id = null;

    /**
     * @var Collection<int, Tag>
     */
    #[ORM\ManyToMany(targetEntity: Tag::class)]
    private Collection $tags;

    #[ORM\Column(options: ['default' => false])]
    private bool|null $defaultGroup = false;

    #[ORM\Column(length: 255)]
    private string|null $title = null;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getId(): int|null
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(
        Tag $tag
    ): static {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(
        Tag $tag
    ): static {
        $this->tags->removeElement($tag);

        return $this;
    }

    public function isDefaultGroup(): bool|null
    {
        return $this->defaultGroup;
    }

    public function setDefaultGroup(
        bool $defaultGroup
    ): static {
        $this->defaultGroup = $defaultGroup;

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
