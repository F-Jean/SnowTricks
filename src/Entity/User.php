<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *      fields = {"email"}, 
 *      message = "L'email est déjà utilisé.")
 * @UniqueEntity(
 *      fields = {"userName"}, 
 *      message = "Ce nom d'utilisateur est déjà utilisé.")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     *      message = "L'email '{{ value }}' n'est pas un email valide."
     * )
     * @Assert\NotBlank(
     *      message = "Veuillez saisir un email."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 3,
     *      max = 20, 
     *      minMessage = "Votre nom d'utilisateur doit contenir au minimum {{ limit }} lettres.",
     *      maxMessage = "Votre nom d'utilisateur ne peut pas faire plus de {{ limit }} lettres."
     * )
     * @Assert\NotBlank(
     *      message = "Veuillez saisir un nom d'utilisateur."
     * )
     */
    private $userName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $avatar;

    /**
     * @var UploadedFile
     */
    private $avatarFile;

    /**
     * @Assert\NotBlank(
     *      message = "Veuillez saisir un mot de passe."
     * )
     * @Assert\Length(
     *      min = 8,
     *      minMessage = "Le mot de passe doit faire minimum {{ limit }} caractères."     
     * )
     * 
     * \S*: any set of characters
     * (?=\S{8,}): of at least length 8
     * (?=\S*[a-z]): containing at least one lowercase letter
     * (?=\S*[A-Z]): and at least one uppercase letter
     * (?=\S*[\d]): and at least one number
     * (?=\S*[\W]): and at least one special character
     * @Assert\Regex(
     *      "/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/",
     *      message = "Le mot de passe {{ value }} ne respect pas les demandes."
     * )
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=255) 
     */
    private $password;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get the value of file
     * @return  UploadedFile
     */ 
    public function getAvatarFile()
    {
        return $this->avatarFile;
    }

    /**
     * Set the value of file
     * @param  UploadedFile  $file
     * @return  self
     */ 
    public function setAvatarFile(UploadedFile $avatarFile)
    {
        $this->avatarFile = $avatarFile;

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getId();
    }
}