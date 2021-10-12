<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', null,[
                'label'=> 'Pesudo : '
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
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ])
            //->add('administrateur')
            //->add('actif')
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => "nom",
                'label' => 'Campus : ',
                'multiple' => true
            ])
            //->add('inscrits')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}