<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use App\Repository\CampusRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'label'=> 'Nom de la sortie : '
            ])
            ->add('dateHeureDebut', null, [
                'label'=> 'Date et heure de la sortie : '
            ])
            ->add('dateLimiteInscription', null, [
                'label'=> "Date limite d\'inscription : "
            ])
            ->add('nbInscriptionsMax', null, [
                'label'=> "Nombre de places : "
            ])
            ->add('duree', null, [
                'label'=> 'durée : ',
                'attr' => ['min'=> 30, 'step'=>15]
            ])
            ->add('infosSortie', null, [
                'label'=> "Description et infos : "
            ])
            ->add('lieu', null, [
                'choice_label'=>"nom",
            ])
           /* ->add('lieu', EntityType::class, [
                'class'=> Lieu::class,
                'label'=> "Lieu : ",
                'choice_label'=>"nom",
                'mapped'=>false, // mapped=>false permet de lui dire que ce champ ne fait
                // pas partie de l'entité liée au formulaire
                'multiple'=>false
            ])

            ->add('latitude', null, [
                'label'=> "latitude : ",
                'mapped'=>false
            ])
            ->add('longitude', null, [
                'label'=> "longitude : ",
                'mapped'=>false
            ])
           */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
