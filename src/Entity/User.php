<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @UniqueEntity(fields={"username"}, message="Este nome de usuário já está em uso.")
 */
class User implements UserInterface, \Serializable, EquatableInterface
{
    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(type="guid")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column()
     * @Assert\NotBlank(message="Preencha seu nome de usuário.")
     * @Assert\Regex("/^[a-z0-9]*$/", message="Seu nome de usuário só pode conter letras minúsculas e números.")
     * @Assert\Length(min=5, minMessage="Seu nome de usuário deve ter ao menos {{ limit }} caracteres.")
     */
    private $username;

    /**
     * @var string
     * @ORM\Column()
     */
    private $password;

    /**
     * @var ?string
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Email(message="Preencha um email válido.", groups={"Profile"})
     * @Assert\Regex("/@example\.(com|org|net)$/", message="Para sua privacidade, use um email @example.com, @example.org ou @example.net.")
     */
    private $email;

    /**
     * @var ?string
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(max=280, minMessage="A citação deve ter até {{ limit }} caracteres.")
     */
    private $favQuote;

    /**
     * @var ?string
     * @ORM\Column(type="string", nullable=true)
     */
    private $avatar;

    /**
     * @var string|null
     * @Assert\NotBlank(message="Preencha sua senha.", groups={"Registration"})
     * @Assert\Length(min=5, minMessage="Sua senha deve ter ao menos {{ limit }} caracteres.", groups={"Registration"})
     */
    public $plainPassword;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    public function __toString()
    {
        return $this->getUsername();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function encodePassword(UserPasswordEncoderInterface $encoder): self
    {
        $this->password = $encoder->encodePassword($this, $this->plainPassword);

        return $this;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = "";
    }

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password,
        ]);
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email = null): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFavQuote(): ?string
    {
        return $this->favQuote;
    }

    public function setFavQuote(?string $favQuote = null): self
    {
        $this->favQuote = $favQuote;

        return $this;
    }

    public function getAvatar(): ?File
    {
        return $this->avatar && file_exists($this->avatar) && is_readable($this->avatar)
            ? new File($this->avatar)
            : null;
    }

    public function setAvatar(?File $avatar = null): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password
        ) = unserialize($serialized);
    }

    public function isEqualTo(UserInterface $user)
    {
        return $user instanceof $this
            && $user->username === $this->username
            && $user->password === $this->password;
    }
}
