<?php

namespace App\Form;

use App\Entity\Lieu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null,[
                'label'=> 'Nom :'
            ])
            ->add('rue', null,[
                'label'=>'Rue : '
            ])
            ->add('latitude', null,[
                'label'=>'Latitude : '
            ])
            ->add('longitude', null,[
                'label'=>'Longitude : '
            ])
            ->add('ville', null,[
                'label'=>'Ville : '
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }
}
