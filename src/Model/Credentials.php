<?php
declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Credentials
{
    /**
     * @Assert\NotBlank(message="Preencha seu nome de usuário.")
     * @Assert\Regex("/^[a-z0-9]*$/", message="Seu nome de usuário só pode conter letras minúsculas e números.")
     * @Assert\Length(min=5, minMessage="Seu nome de usuário deve ter ao menos {{ limit }} caracteres.")
     */
    public $username;

    /**
     * @Assert\NotBlank(message="Preencha sua senha.")
     * @Assert\Length(min=5, minMessage="Sua senha deve ter ao menos {{ limit }} caracteres.")
     */
    public $password;
}