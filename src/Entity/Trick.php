<?php

namespace App\Entity;

use App\Repository\TrickRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Validator\Constraints as TrickAssert;

/**
 * @ORM\Entity(repositoryClass=TrickRepository::class)
 * @UniqueEntity(
 *   fields = {"slug"},
 *   errorPath = "name", 
 *   message = "Cette figure existe déjà !"
 * )
 * @TrickAssert\SlugExists
 */
class Trick
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *   message = "Veuillez saisir le nom de la figure."
     * )
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid
     */
    private $category;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(
     *   message = "Veuillez saisir une description."
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $addedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="trick", fetch="EXTRA_LAZY", cascade={"persist"}, orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=Illustration::class, mappedBy="trick", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Count(
     *   min = 1,
     *   minMessage = "Merci d'ajouter au minimum une image."
     * )
     * @Assert\Valid
     * @Assert\NotBlank(
     *   message = "Merci de sélectionner une image ou de supprimer le champ vide"
     * )
     */
    private $illustrations;

    /**
     * @ORM\OneToMany(targetEntity=Video::class, mappedBy="trick", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid
     */
    private $videos;

    public function __construct()
    {
        $this->addedAt = new \DateTimeImmutable();
        $this->comments = new ArrayCollection();
        $this->illustrations = new ArrayCollection();
        $this->videos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getAddedAt(): ?\DateTimeImmutable
    {
        return $this->addedAt;
    }

    public function setAddedAt(\DateTimeImmutable $addedAt): self
    {
        $this->addedAt = $addedAt;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * @return Collection|Illustration[]
     */
    public function getIllustrations(): Collection
    {
        return $this->illustrations;
    }

    /**
     * @param Illustration $illustration
     * @return void
     */
    public function addIllustration(Illustration $illustration): void
    {
        $illustration->setTrick($this);
        $this->illustrations->add($illustration);
    }

    /**
     * @param Illustration $illustration
     * @return void
     */
    public function removeIllustration(Illustration $illustration): void
    {
        $illustration->setTrick(null);
        $this->illustrations->removeElement($illustration);
    }

    /**
     * @return Collection|Video[]
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    /**
     * @param Video $video
     * @return void
     */
    public function addVideo(Video $video): void
    {
        $video->setTrick($this);
        $this->videos->add($video);
    }

    /**
     * @param Video $video
     * @return void
     */
    public function removeVideo(Video $video): void
    {
        $video->setTrick(null);
        $this->videos->removeElement($video);
    }
}
