<?php

namespace App\Entity\Rss;

use App\Repository\Rss\SearchRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SearchRepository::class)
 * @ORM\Table(name="rss__search")
 */
class Search
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $query;

    /**
     * @ORM\ManyToOne(targetEntity=Group::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Group $rssGroup;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuery(): ?string
    {
        return $this->query;
    }

    public function setQuery(string $query): self
    {
        $this->query = $query;

        return $this;
    }

    public function getRssGroup(): ?Group
    {
        return $this->rssGroup;
    }

    public function setRssGroup(?Group $rssGroup): self
    {
        $this->rssGroup = $rssGroup;

        return $this;
    }
}
