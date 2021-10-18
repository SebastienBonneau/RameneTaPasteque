<?php

namespace App\Form;

use App\Entity\Sortie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnulerSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null,[
                'label'=>'Nom de la sortie :'
            ])
            ->add('dateHeureDebut', null,[
                'label'=>'Date de la sortie :'
            ])
           /* ->add('campus', null,[
                'label'=>'Campus :',
                'choice_label'
            ])
            ->add('lieu', null,[
                'label'=>'Lieu :'
            ])
           */
            ->add('infosSortie', null,[
                'label'=> 'motif :'
            ])



        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
