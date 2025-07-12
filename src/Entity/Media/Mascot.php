<?php

declare(strict_types=1);

namespace App\Entity\Media;

use App\Repository\Media\MascotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MascotRepository::class)]
class Mascot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int|null $id = null;

    #[ORM\Column(length: 2048)]
    private string|null $path = null;

    /**
     * @var Collection<int, Tag>
     */
    #[ORM\ManyToMany(targetEntity: Tag::class)]
    private Collection $tags;

    #[ORM\Column(length: 255)]
    private string|null $ext = null;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getId(): int|null
    {
        return $this->id;
    }

    public function getPath(): string|null
    {
        return $this->path;
    }

    public function setPath(
        string $path
    ): static {
        $this->path = $path;

        return $this;
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

    public function getExt(): string|null
    {
        return $this->ext;
    }

    public function setExt(
        string $ext
    ): static {
        $this->ext = $ext;

        return $this;
    }
}
