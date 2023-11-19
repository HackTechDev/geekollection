<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'movies')]
    private ?Media $media = null;

    #[ORM\ManyToOne(inversedBy: 'movies')]
    private ?Support $support = null;

    #[Gedmo\Timestampable(on:"update")]
    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created_at;
 
    #[Gedmo\Timestampable(on:"update")]
    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updated_at;

    #[ORM\ManyToMany(targetEntity: Library::class, mappedBy: 'movie')]
    private Collection $libraries;

    #[ORM\ManyToOne(inversedBy: 'movies')]
    private ?Box $box = null;

    #[ORM\ManyToOne(inversedBy: 'movies')]
    private ?Edition $edition = null;

    #[ORM\Column(length: 255)]
    private ?string $objectlink = null;

    #[ORM\Column(length: 255)]
    private ?string $oeuvrelink = null;

    #[ORM\Column(length: 255)]
    private ?string $gencode = null;

    public function __construct()
    {
        $this->libraries = new ArrayCollection();
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

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(?Media $media): static
    {
        $this->media = $media;

        return $this;
    }

    public function getSupport(): ?Support
    {
        return $this->support;
    }

    public function setSupport(?Support $support): static
    {
        $this->support = $support;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }
 
    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;
 
        return $this;
    }
 
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }
 
    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;
 
        return $this;
    }

    /**
     * @return Collection<int, Library>
     */
    public function getLibraries(): Collection
    {
        return $this->libraries;
    }

    public function addLibrary(Library $library): static
    {
        if (!$this->libraries->contains($library)) {
            $this->libraries->add($library);
            $library->addMovie($this);
        }

        return $this;
    }

    public function removeLibrary(Library $library): static
    {
        if ($this->libraries->removeElement($library)) {
            $library->removeMovie($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getTitle() . " / " . $this->getSupport()->label . " / " . $this->getBox()->label . " / " . $this->getEdition()->label;
    }

    public function getBox(): ?Box
    {
        return $this->box;
    }

    public function setBox(?Box $box): static
    {
        $this->box = $box;

        return $this;
    }

    public function getEdition(): ?Edition
    {
        return $this->edition;
    }

    public function setEdition(?Edition $edition): static
    {
        $this->edition = $edition;

        return $this;
    }

    public function getObjectlink(): ?string
    {
        return $this->objectlink;
    }

    public function setObjectlink(string $objectlink): static
    {
        $this->objectlink = $objectlink;

        return $this;
    }

    public function getOeuvrelink(): ?string
    {
        return $this->oeuvrelink;
    }

    public function setOeuvrelink(string $oeuvrelink): static
    {
        $this->oeuvrelink = $oeuvrelink;

        return $this;
    }

    public function getGencode(): ?string
    {
        return $this->gencode;
    }

    public function setGencode(string $gencode): static
    {
        $this->gencode = $gencode;

        return $this;
    }
}
