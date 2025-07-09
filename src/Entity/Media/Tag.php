<?php

namespace App\Entity\Media;

use App\Repository\Media\TagRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'tags')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TagGroup $tagGroup = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $meta = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTagGroup(): ?TagGroup
    {
        return $this->tagGroup;
    }

    public function setTagGroup(?TagGroup $tagGroup): static
    {
        $this->tagGroup = $tagGroup;

        return $this;
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

    public function getMeta(): ?int
    {
        return $this->meta;
    }

    public function setMeta(?int $meta): static
    {
        $this->meta = $meta;

        return $this;
    }
}
