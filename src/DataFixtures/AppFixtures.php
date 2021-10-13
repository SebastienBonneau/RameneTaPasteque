<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $etat1 = new Etat();
        $etat1->setLibelle("Créée");
        $manager->persist($etat1);
        $manager->flush();

        $etat2 = new Etat();
        $etat2->setLibelle("Ouverte");
        $manager->persist($etat2);
        $manager->flush();

        $etat3 = new Etat();
        $etat3->setLibelle("Clôturée");
        $manager->persist($etat3);
        $manager->flush();

        $etat4 = new Etat();
        $etat4->setLibelle("Activité en cours");
        $manager->persist($etat4);
        $manager->flush();

        $etat5 = new Etat();
        $etat5->setLibelle("Passée");
        $manager->persist($etat5);
        $manager->flush();

        $etat6 = new Etat();
        $etat6->setLibelle("Annulée");
        $manager->persist($etat6);
        $manager->flush();



        $ville1 = new Ville();
        $ville1-> setNom("Romville");
        $ville1-> setCodePostal("85185");
        $manager->persist($ville1);
        $manager-> flush();

        $ville2 = new Ville();
        $ville2-> setNom("Pouceville");
        $ville2-> setCodePostal("44030");
        $manager->persist($ville2);
        $manager-> flush();

        $ville3 = new Ville();
        $ville3-> setNom("Videville");
        $ville3-> setCodePostal("56018");
        $manager->persist($ville3);
        $manager-> flush();

        $ville4 = new Ville();
        $ville4-> setNom("Aieville");
        $ville4-> setCodePostal("49049");
        $manager->persist($ville4);
        $manager-> flush();



        $lieu1 = new Lieu();
        $lieu1-> setNom("la plage des sables");
        $lieu1-> setRue("rue des poilus");
        $lieu1-> setVille($ville1);
        $manager->persist($lieu1);
        $manager-> flush();

        $lieu2 = new Lieu();
        $lieu2-> setNom("le lac de samouass");
        $lieu2-> setRue("rue du petit pois");
        $lieu2-> setVille($ville2);
        $manager->persist($lieu2);
        $manager-> flush();

        $lieu3 = new Lieu();
        $lieu3-> setNom("Aeroport de splash");
        $lieu3-> setRue("boulevard des champs");
        $lieu3-> setVille($ville3);
        $manager->persist($lieu3);
        $manager-> flush();

        $lieu4 = new Lieu();
        $lieu4-> setNom("La foret des mordus");
        $lieu4-> setRue("chemin de belespoir");
        $lieu4-> setVille($ville4);
        $manager->persist($lieu4);
        $manager-> flush();







        $campus1 = new Campus();
        $campus1->setNom("Barbus Campus");
        $manager->persist($campus1);
        $manager->flush();

        $campus2 = new Campus();
        $campus2->setNom("Shark Campus");
        $manager->persist($campus2);
        $manager->flush();

        $campus3 = new Campus();
        $campus3->setNom("Geek Campus ");
        $manager->persist($campus3);
        $manager->flush();

        $campus4 = new Campus();
        $campus4->setNom("Poule Campus");
        $manager->persist($campus4);
        $manager->flush();

        $campus5 = new Campus();
        $campus5->setNom("Chauve Campus");
        $manager->persist($campus5);
        $manager->flush();



        $participant1 = new Participant();
        $participant1-> setPseudo("heyjo");
        $participant1-> setNom("HEY");
        $participant1-> setPrenom("John");
        $participant1-> setTelephone("01.02.03.30.20");
        $participant1-> setEmail("john.hey@gmail.com");
        $participant1-> setPassword("$2y$13\$idY/Bn2/DEcTBGfk1AzfX.IGk6GBNkhrYL4xiaHnTpf3Eu6kI71l2");
        $participant1->setRoles(['ROLE_USER']);
        $participant1-> setAdministrateur(false);
        $participant1-> setActif(true);
        $participant1->setCampus($campus1);
        $manager->persist($participant1);
        $manager->flush();

        $participant2 = new Participant();
        $participant2-> setPseudo("jcdus");
        $participant2-> setNom("DUS");
        $participant2-> setPrenom("Jean-claude");
        $participant2-> setTelephone("01.72.83.35.25");
        $participant2-> setEmail("jcdus@gmail.com");
        $participant2-> setPassword("$2y$13\$idY/Bn2/DEcTBGfk1AzfX.IGk6GBNkhrYL4xiaHnTpf3Eu6kI71l2");
        $participant2->setRoles(['ROLE_USER']);
        $participant2-> setAdministrateur(false);
        $participant2-> setActif(false);
        $participant2->setCampus($campus2);
        $manager->persist($participant2);
        $manager->flush();

        $participant3 = new Participant();
        $participant3-> setPseudo("josiane");
        $participant3-> setNom("LABELLE");
        $participant3-> setPrenom("Josiane");
        $participant3-> setTelephone("01.72.83.35.25");
        $participant3-> setEmail("jojo@gmail.com");
        $participant3-> setPassword("$2y$13\$idY/Bn2/DEcTBGfk1AzfX.IGk6GBNkhrYL4xiaHnTpf3Eu6kI71l2");
        $participant3->setRoles(['ROLE_ADMIN']);
        $participant3-> setAdministrateur(true);
        $participant3-> setActif(true);
        $participant3->setCampus($campus3);
        $manager->persist($participant3);
        $manager->flush();

        $participant4 = new Participant();
        $participant4-> setPseudo("chantal");
        $participant4-> setNom("LAFORTE");
        $participant4-> setPrenom("Chantal");
        $participant4-> setTelephone("01.72.00.65.25");
        $participant4-> setEmail("chanchan@gmail.com");
        $participant4-> setPassword("$2y$13\$idY/Bn2/DEcTBGfk1AzfX.IGk6GBNkhrYL4xiaHnTpf3Eu6kI71l2");
        $participant4->setRoles(['ROLE_ADMIN']);
        $participant4-> setAdministrateur(true);
        $participant4-> setActif(true);
        $participant4->setCampus($campus4);
        $manager->persist($participant4);
        $manager->flush();



        $sortie1 = new Sortie();
        $sortie1-> setNom("Attrappe la meduse");
        $sortie1-> setDateHeureDebut(new \datetime("10-09-2021"));
        $sortie1-> setDuree(999);
        $sortie1-> setDateLimiteInscription(new \datetime("08-09-2021"));
        $sortie1-> setNbInscriptionsMax(300);
        $sortie1-> setInfosSortie("A main nu, a toi de ramener le plus de meduses pour remporter notre super cadeau, le livre 'Histoire de Geek' edition ENI.");
        $sortie1-> setCampus($campus1);
        $sortie1-> setEtat($etat1);
        $sortie1->setLieu($lieu1);
        $sortie1-> setOrganisateur($participant3);
        $manager->persist($sortie1);
        $manager->flush();


        $sortie2 = new Sortie();
        $sortie2-> setNom("pedalo");
        $sortie2-> setDateHeureDebut(new \datetime("20-10-2021"));
        $sortie2-> setDuree(120);
        $sortie2-> setDateLimiteInscription(new \datetime("18-10-2021"));
        $sortie2-> setNbInscriptionsMax(80);
        $sortie2-> setInfosSortie("le but est de savoir nager, tous nos pédalos sont sur le points de couler, a vous de noyer vos concurrents");
        $sortie2-> setCampus($campus2);
        $sortie2-> setEtat($etat2);
        $sortie2->setLieu($lieu2);
        $sortie2-> setOrganisateur($participant3);
        $manager->persist($sortie2);
        $manager->flush();

        $sortie3 = new Sortie();
        $sortie3-> setNom("Le Grand saut !!");
        $sortie3-> setDateHeureDebut(new \datetime("10-11-2021"));
        $sortie3-> setDuree(30);
        $sortie3-> setDateLimiteInscription(new \datetime("08-11-2021"));
        $sortie3-> setNbInscriptionsMax(14);
        $sortie3-> setInfosSortie("A nous le grand saut en parachute, nous convions 14 participants mais nous possedons seulement 10 parachutes, ATTENTION vous etes obligé de sauter");
        $sortie3-> setCampus($campus3);
        $sortie3-> setEtat($etat3);
        $sortie3->setLieu($lieu3);
        $sortie3-> setOrganisateur($participant3);
        $manager->persist($sortie3);
        $manager->flush();

        $sortie4 = new Sortie();
        $sortie4-> setNom("Croquer la Pômme.");
        $sortie4-> setDateHeureDebut(new \datetime("14-12-2021"));
        $sortie4-> setDuree(10);
        $sortie4-> setDateLimiteInscription(new \datetime("14-12-2021"));
        $sortie4-> setNbInscriptionsMax(1500);
        $sortie4-> setInfosSortie("Rien de tel que ce faire plaisir avant noel, pleins de cadeau sont a remporter a condition de croquer la pomme. Le jeu se deroule par equipe de 2 minimum, un joueur mets une pomme sur sa tete et l'autre joueur a 3 couteaux. Si apres avoir lancé ses couteaux le joueur a touché la pomme il remporte un cadeau sinon c'est perdu !! a vous de rejouer.");
        $sortie4-> setCampus($campus4);
        $sortie4-> setEtat($etat3);
        $sortie4->setLieu($lieu4);
        $sortie4-> setOrganisateur($participant4);
        $manager->persist($sortie4);
        $manager->flush();




    }
}
