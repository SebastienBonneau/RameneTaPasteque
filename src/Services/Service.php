<?php

namespace App\Services;

use App\Entity\Participant;

class Service
{



    public function verifInscription($participants, $utilisateur){

        foreach ($participants as $p){
            if($utilisateur->getId() == $p->getId()){
                return true;
            }
        }return false;
    }
}