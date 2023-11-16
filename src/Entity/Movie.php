<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use  Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: MovieRepository::class)]
/**
 * Summary of Movie
 */
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    /**
     * Summary of id
     * @var 
     */
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    /**
     * Summary of title
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min="5")
     * @var 
     */
    private ?string $title = null;

    #[ORM\Column]
    /**
     * Summary of releaseYear
     * @var 
     */
    private ?int $releaseYear = null;

    #[ORM\Column(length: 255, nullable: true)]
    /**
     * Summary of description
     * @Assert\NotBlank
     * @var 
     */
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    /**
     * Summary of imagePath
     * @var 
     */
    private ?string $imagePath = null;

    #[ORM\ManyToMany(targetEntity: Actor::class, inversedBy: 'movies')]
    /**
     * Summary of actors
     * @var Collection
     */
    private Collection $actors;

    #[ORM\ManyToOne(inversedBy: 'movies')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'movie', targetEntity: Comment::class)]
    private Collection $comments;

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->actors = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    /**
     * Summary of getId
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Summary of getTitle
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Summary of setTitle
     * @param string $title
     * @return static
     */
    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Summary of getReleaseYear
     * @return int|null
     */
    public function getReleaseYear(): ?int
    {
        return $this->releaseYear;
    }

    /**
     * Summary of setReleaseYear
     * @param int $releaseYear
     * @return static
     */
    public function setReleaseYear(?int $releaseYear): static
    {
        $this->releaseYear = $releaseYear;

        return $this;
    }

    /**
     * Summary of getDescription
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Summary of setDescription
     * @param mixed $description
     * @return static
     */
    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Summary of getImagePath
     * @return string|null
     */
    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    /**
     * Summary of setImagePath
     * @param string $imagePath
     * @return static
     */
    public function setImagePath(string $imagePath): static
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    /**
     * @return Collection<int, Actor>
     */
    public function getActors(): Collection
    {
        return $this->actors;
    }

    /**
     * Summary of addActor
     * @param \App\Entity\Actor $actor
     * @return static
     */
    public function addActor(Actor $actor): static
    {
        if (!$this->actors->contains($actor)) {
            $this->actors->add($actor);
        }

        return $this;
    }

    /**
     * Summary of removeActor
     * @param \App\Entity\Actor $actor
     * @return static
     */
    public function removeActor(Actor $actor): static
    {
        $this->actors->removeElement($actor);

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setMovie($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getMovie() === $this) {
                $comment->setMovie(null);
            }
        }

        return $this;
    }
}
