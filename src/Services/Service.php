<?php

namespace App\Services;

use App\Entity\Participant;
use Symfony\Component\Validator\Constraints\Date;


class Service
{


    /**
     * Méthode qui permet de vérifier si l'user connecté est inscrit ou non à une sortie affichée.
     * Cette méthode sera utilisée dans le contrôleur pour vérifier l'inscription de l'user connecté
     * à la liste des sorties
     * Le résultat de cette méthode sera utilisée dans le js pour gérer l'affichage de la colonne 'inscrit'
     * du tableau affiché dans sortie/liste.html.twig
     * @param $participants
     * @param $userConnecte
     * @return bool
     */
    public function verifInscription($participants, $userConnecte){
        // On parcourt avec une boucle le tableau des participants à une sortie
        foreach ($participants as $p){
            // si l'id de l'userConnecté est trouvé dans le tableau des participants
            if($userConnecte->getId() == $p->getId()){
                //la méthode retourne true
                return true;
            }
            // sinon elle retourne false
        }return false;
    }

    /**
     *
     * Méthode qui permet de vérifier si l'user connecté est l'organisateur de la sortie
     */
    public function verifUserConnectedOrganisateur($organisateur, $userConnecte)
    {
            if ($userConnecte->getId() == $organisateur->getId()) {
                return true;
            }return false;
    }

    /**
     *
     * Méthode qui permet de vérifier si le lien annuler est affichable
     */
    public function verifLienAnuler($organisateur, $userConnecte, $dateHeureDebut,$etat)
    {
        $dateDuJour = new Date();
        if ($userConnecte->getId() == $organisateur->getId() && $dateDuJour<$dateHeureDebut && $etat->getId()<=2) {
            return true;
        }   return false;

    }
}