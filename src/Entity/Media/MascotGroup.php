<?php

declare(strict_types=1);

namespace App\Entity\Media;

use App\Repository\Media\MascotGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: MascotGroupRepository::class)]
class MascotGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('api')]
    private int|null $id = null;

    /**
     * @var Collection<int, Tag>
     */
    #[ORM\ManyToMany(targetEntity: Tag::class)]
    private Collection $tags;

    #[ORM\Column(length: 255)]
    #[Groups('api')]
    private string|null $title = null;

    /**
     * @var Collection<int, ApiLink>
     */
    #[ORM\OneToMany(targetEntity: ApiLink::class, mappedBy: 'mascotGroup')]
    private Collection $apiLinks;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->apiLinks = new ArrayCollection();
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

    /**
     * @return Collection<int, ApiLink>
     */
    public function getApiLinks(): Collection
    {
        return $this->apiLinks;
    }

    public function addApiLink(ApiLink $apiLink): static
    {
        if (!$this->apiLinks->contains($apiLink)) {
            $this->apiLinks->add($apiLink);
            $apiLink->setMascotGroup($this);
        }

        return $this;
    }

    public function removeApiLink(ApiLink $apiLink): static
    {
        if ($this->apiLinks->removeElement($apiLink)) {
            // set the owning side to null (unless already changed)
            if ($apiLink->getMascotGroup() === $this) {
                $apiLink->setMascotGroup(null);
            }
        }

        return $this;
    }
}
