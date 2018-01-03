<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => "Nome de usuário",
            ])
            ->add('plainPassword', RepeatedType::class, [
                'label' => "Senha",
                'type' => PasswordType::class,
                'first_options' => ['label' => "Senha"],
                'second_options' => ['label' => "Repita sua senha"]
            ])
        ;
    }

    public function getBlockPrefix()
    {
        return "register";
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => ['User', 'Registration'],
            'translation_domain' => false,
        ]);
    }

}
