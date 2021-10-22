<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', null,[
                'label'=> 'Pseudo : '
            ])
            ->add('prenom', null,[
                'label'=> 'Prénom : '
            ])
            ->add('nom', null,[
                'label'=> 'Nom : '
            ])
            ->add('telephone', null,[
                'label'=> 'téléphone : '
            ])
            ->add('email', null,[
                'label'=>'Email :'
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => false,
                'first_options'  => ['label' => 'Nouveau mot de passe : '],
                'second_options' => ['label' => 'Comfirmer mot de passe : '],
            ])
            ->add('campus', null, [
                'choice_label' => "nom",
                'label' => 'Campus : '
            ])
            ->add('photo', FileType::class,[
                'label' => 'Télécharger votre photo :',
                'mapped'=> false,
                'required' => false,

                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/*'
                        ],
                        'mimeTypesMessage' => "Ce format d/'image n/'est pas accepter.",
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
