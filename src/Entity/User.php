<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *      fields = {"email"}, 
 *      message = "L'email est déjà utilisé.")
 * @UniqueEntity(
 *      fields = {"userName"}, 
 *      message = "Ce nom d'utilisateur est déjà utilisé.")
 */
class User implements UserInterface, \Serializable
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
     * @ORM\Column(type="string", length=255, nullable=true)
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

    /**
     * @ORM\Column(type="uuid", nullable=true, unique=true)
     */
    private $token;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @ORM\Column(type="uuid", length=255, nullable=true, unique=true)
     */
    private $resetToken;

    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
        // the account is disactivated after the inscription
        $this->enabled = false;
    }

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
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
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

    public function serialize()
    {
        return serialize([$this->id, $this->email, $this->userName, $this->avatar, $this->password, $this->roles]);
    }

    public function unserialize($serialized)
    {
        list ($this->id, $this->email, $this->userName, $this->avatar, $this->password, $this->roles) = unserialize($serialized, ['allowed_classes' => false]);
    }

    public function getToken(): ?Uuid
    {
        return $this->token;
    }

    public function setToken(?Uuid $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getResetToken(): ?Uuid
    {
        return $this->resetToken;
    }

    public function setResetToken(?Uuid $resetToken): self
    {
        $this->resetToken = $resetToken;

        return $this;
    }
}