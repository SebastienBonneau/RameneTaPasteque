<?php

namespace App\Form;

use App\Entity\Sortie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifierSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null,[
                'label'=> 'Nom de la sortie :'
            ])
            ->add('dateHeureDebut',DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date et heure de la sortie : '
            ])
            ->add('dateLimiteInscription',DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date limite d\'inscription : '
            ])
            ->add('nbInscriptionsMax', null, [
                'label'=> 'Nombre de places :'
            ])
            ->add('duree', null, [
                'label'=> 'durée : ',
                'attr' => ['min'=> 30, 'step'=>15]
            ])
            ->add('infosSortie', null, [
                'label'=> "Description et infos : "
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
