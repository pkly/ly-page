<?php

declare(strict_types=1);

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
    private int|null $id = null;

    #[ORM\ManyToOne(inversedBy: 'tags')]
    #[ORM\JoinColumn(nullable: false)]
    private TagGroup|null $tagGroup = null;

    #[ORM\Column(length: 255)]
    private string|null $title = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private int|null $meta = null;

    public function __toString(): string
    {
        return $this->getTitle().' - '.$this->getTagGroup()->getTitle();
    }

    public function getId(): int|null
    {
        return $this->id;
    }

    public function getTagGroup(): TagGroup|null
    {
        return $this->tagGroup;
    }

    public function setTagGroup(
        TagGroup|null $tagGroup
    ): static {
        $this->tagGroup = $tagGroup;

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

    public function getMeta(): int|null
    {
        return $this->meta;
    }

    public function setMeta(
        int|null $meta
    ): static {
        $this->meta = $meta;

        return $this;
    }
}
