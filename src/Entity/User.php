<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
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
     * @var string|null
     * @Assert\NotBlank(message="Preencha sua senha.", groups={"Registration"})
     * @Assert\Length(min=5, minMessage="Sua senha deve ter ao menos {{ limit }} caracteres.", groups={"Registration"})
     */
    public $plainPassword;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
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
