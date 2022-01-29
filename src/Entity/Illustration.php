<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\IllustrationRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=IllustrationRepository::class)
 */
class Illustration
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /** 
     * @var UploadedFile
     * @Assert\NotNull(groups="add")
     * @Assert\Image(groups="add")
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity=Trick::class, inversedBy="illustrations")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $trick;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

    public function setTrick(?Trick $trick): self
    {
        $this->trick = $trick;
        return $this;
    }

    /**
     * Get the value of file
     * @return  UploadedFile
     */ 
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set the value of file
     * @param  UploadedFile  $file
     * @return  self
     */ 
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
        return $this;
    }
}
