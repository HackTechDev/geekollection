<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'items')]
    private Collection $user;

    #[ORM\ManyToMany(targetEntity: Movie::class, inversedBy: 'items')]
    private Collection $movie;

    #[Gedmo\Timestampable(on:"update")]
    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created_at;
 
    #[Gedmo\Timestampable(on:"update")]
    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updated_at;

    #[ORM\Column(length: 255)]
    private ?string $information = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->movie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        $this->user->removeElement($user);

        return $this;
    }

    /**
     * @return Collection<int, Movie>
     */
    public function getMovie(): Collection
    {
        return $this->movie;
    }

    public function addMovie(Movie $movie): static
    {
        if (!$this->movie->contains($movie)) {
            $this->movie->add($movie);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): static
    {
        $this->movie->removeElement($movie);

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

    public function getInformation(): ?string
    {
        return $this->information;
    }

    public function setInformation(string $information): static
    {
        $this->information = $information;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }


    private $selectedData;

    public function getSelectedData()
    {
        return $this->selectedData;
    }

    public function setSelectedData($selectedData)
    {
        $this->selectedData= $selectedData;
    }
}
