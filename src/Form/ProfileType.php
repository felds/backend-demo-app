<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    /**
     * @var string
     */
    private $imagesDir;

    public function __construct(string $imagesDir)
    {
        $this->imagesDir = $imagesDir;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('avatarFile', FileType::class, [
                'label' => "Avatar",
                'mapped' => false,
            ])
            ->add('email', EmailType::class, [
                'label' => "Email",
            ])
            ->add('favQuote', TextareaType::class, [
                'label' => "Citação favorita",
            ])
        ;

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $file = $event->getForm()->get('avatarFile')->getData();
            $data = $event->getData();

            if (!$file) return;

            if (!$file instanceof File) throw new \RuntimeException("File... wel... is not a file!");
            if (!$data instanceof User) throw new \RuntimeException("Entity should be a user.");

            if ($data->getAvatar() && $file) {
                @unlink($data->getAvatar()->getRealPath());
                $data->setAvatar();
            }

            if ($file) {
                $filename = sprintf('%s.%s', uniqid(), $file->guessExtension() ?: '.png');
                $uploadedFile = $file->move($this->imagesDir, $filename);
                $data->setAvatar($uploadedFile);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => ['User', 'Profile'],
            'translation_domain' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'profile';
    }
}
