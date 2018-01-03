<?php
declare(strict_types=1);

namespace App\Entity;

use App\Model\Credentials;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity()
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
     */
    private $username;

    /**
     * @var string
     * @ORM\Column()
     */
    private $password;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    static public function fromCredentials(Credentials $credentials, UserPasswordEncoderInterface $encoder): self
    {
        $obj = new static();
        $obj->setCredentials($credentials, $encoder);

        return $obj;
    }

    private function setCredentials(Credentials $credentials, UserPasswordEncoderInterface $encoder): self
    {
        $this->username = $credentials->username;
        $this->setPassword($credentials->password, $encoder);

        return $this;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $plainPassword, UserPasswordEncoderInterface $encoder): self
    {
        $this->password = $encoder->encodePassword($this, $plainPassword);

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

    public function eraseCredentials()
    {}

    public function serialize()
    {
        return serialize([
            $this->username,
            $this->password,
        ]);
    }

    public function unserialize($serialized)
    {
        list (
            $this->username,
            $this->password
        ) = $this->unserialize($serialized);
    }

    public function isEqualTo(UserInterface $user)
    {
        return $user instanceof $this
            && $user->username === $this->username
            && $user->password === $this->password;
    }
}