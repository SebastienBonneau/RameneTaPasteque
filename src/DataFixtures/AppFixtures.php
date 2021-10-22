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

        //----------------------------------

        $ville1 = new Ville();
        $ville1-> setNom("Les Sables d'Olonne");
        $ville1-> setCodePostal("85100");
        $manager->persist($ville1);
        $manager-> flush();

        $ville2 = new Ville();
        $ville2-> setNom("St Philbert de Grand Lieu");
        $ville2-> setCodePostal("44030");
        $manager->persist($ville2);
        $manager-> flush();

        $ville3 = new Ville();
        $ville3-> setNom("Vannes");
        $ville3-> setCodePostal("56000");
        $manager->persist($ville3);
        $manager-> flush();

        $ville4 = new Ville();
        $ville4-> setNom("Angers");
        $ville4-> setCodePostal("49000");
        $manager->persist($ville4);
        $manager-> flush();

        //----------------------------------

        $lieu1 = new Lieu();
        $lieu1-> setNom("la plage des sables");
        $lieu1-> setRue("rue des marins");
        $lieu1-> setLatitude("46.492958");
        $lieu1-> setLongitude("-1.795493");
        $lieu1-> setVille($ville1);
        $manager->persist($lieu1);
        $manager-> flush();

        $lieu2 = new Lieu();
        $lieu2-> setNom("le lac de samouass");
        $lieu2-> setRue("rue du petit pois");
        $lieu2-> setLatitude("47.036878");
        $lieu2-> setLongitude("-1.642905");
        $lieu2-> setVille($ville2);
        $manager->persist($lieu2);
        $manager-> flush();

        $lieu3 = new Lieu();
        $lieu3-> setNom("Aeroport de splash");
        $lieu3-> setRue("boulevard des champs");
        $lieu3-> setLatitude("47.658236");
        $lieu3-> setLongitude("-2.760847");
        $lieu3-> setVille($ville3);
        $manager->persist($lieu3);
        $manager-> flush();

        $lieu4 = new Lieu();
        $lieu4-> setNom("La foret des elfes");
        $lieu4-> setRue("chemin de bel espoir");
        $lieu4-> setLatitude("47.478419");
        $lieu4-> setLongitude("-0.563166");
        $lieu4-> setVille($ville4);
        $manager->persist($lieu4);
        $manager-> flush();

        $lieu5 = new Lieu();
        $lieu5-> setNom("La plage des pastèques");
        $lieu5-> setRue("boulevard de l'océan");
        $lieu5-> setLatitude("47.658236");
        $lieu5-> setLongitude("-2.760847");
        $lieu5-> setVille($ville3);
        $manager->persist($lieu5);
        $manager-> flush();

        //----------------------------------

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
        $campus5->setNom("Papaye Campus");
        $manager->persist($campus5);
        $manager->flush();

        //----------------------------------

        $participant1 = new Participant();
        $participant1-> setPseudo("jojo");
        $participant1-> setNom("HEY");
        $participant1-> setPrenom("John");
        $participant1-> setTelephone("01.02.03.30.20");
        $participant1-> setEmail("john.hey@gmail.com");
        $participant1-> setPassword("$2y$13\$idY/Bn2/DEcTBGfk1AzfX.IGk6GBNkhrYL4xiaHnTpf3Eu6kI71l2");
        $participant1->setRoles(['ROLE_USER']);
        $participant1-> setAdministrateur(false);
        $participant1-> setActif(true);
        $participant1->setCampus($campus1);
        $participant1->setPhoto("sandia.jpg");
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
        $participant2->setPhoto("jcdus.jpg");
        $manager->persist($participant2);
        $manager->flush();

        $participant3 = new Participant();
        $participant3-> setPseudo("josy");
        $participant3-> setNom("LABELLE");
        $participant3-> setPrenom("Josiane");
        $participant3-> setTelephone("01.72.83.35.25");
        $participant3-> setEmail("jojo@gmail.com");
        $participant3-> setPassword("$2y$13\$idY/Bn2/DEcTBGfk1AzfX.IGk6GBNkhrYL4xiaHnTpf3Eu6kI71l2");
        $participant3->setRoles(['ROLE_ADMIN']);
        $participant3-> setAdministrateur(true);
        $participant3-> setActif(true);
        $participant3->setCampus($campus3);
        $participant3->setPhoto("josy.jpg");
        $manager->persist($participant3);
        $manager->flush();

        $participant4 = new Participant();
        $participant4-> setPseudo("chanchan");
        $participant4-> setNom("LAFORTE");
        $participant4-> setPrenom("Chantal");
        $participant4-> setTelephone("01.72.00.65.25");
        $participant4-> setEmail("chanchan@gmail.com");
        $participant4-> setPassword("$2y$13\$idY/Bn2/DEcTBGfk1AzfX.IGk6GBNkhrYL4xiaHnTpf3Eu6kI71l2");
        $participant4->setRoles(['ROLE_ADMIN']);
        $participant4-> setAdministrateur(true);
        $participant4-> setActif(true);
        $participant4->setCampus($campus4);
        $participant4->setphoto("chanchan.jpg");
        $manager->persist($participant4);
        $manager->flush();

        //----------------------------------

        $sortie1 = new Sortie();
        $sortie1-> setNom("Attrappe la meduse");
        $sortie1-> setDateHeureDebut(new \datetime("10-11-2021"));
        $sortie1-> setDuree(999);
        $sortie1-> setDateLimiteInscription(new \datetime("08-11-2021"));
        $sortie1-> setNbInscriptionsMax(10);
        $sortie1-> setInfosSortie("A main nue, à toi de ramener le plus de méduses pour remporter notre super cadeau, le livre 'Histoire de Geek' edition ENI.");
        $sortie1-> setCampus($campus1);
        $sortie1-> setEtat($etat1);
        $sortie1->setLieu($lieu1);
        $sortie1-> setOrganisateur($participant1);
        $manager->persist($sortie1);
        $manager->flush();

        $sortie2 = new Sortie();
        $sortie2-> setNom("pedalo");
        $sortie2-> setDateHeureDebut(new \datetime("20-11-2021"));
        $sortie2-> setDuree(120);
        $sortie2-> setDateLimiteInscription(new \datetime("18-11-2021"));
        $sortie2-> setNbInscriptionsMax(20);
        $sortie2-> setInfosSortie("le but est d'atteindre la rive le premier, avec des pédalos qui ont parfois quelques avaries... A vous de vaincre les éléments !");
        $sortie2-> setCampus($campus2);
        $sortie2-> setEtat($etat2);
        $sortie2->setLieu($lieu2);
        $sortie2-> setOrganisateur($participant3);
        $manager->persist($sortie2);
        $manager->flush();

        $sortie3 = new Sortie();
        $sortie3-> setNom("Le Grand saut !!");
        $sortie3-> setDateHeureDebut(new \datetime("10-12-2021"));
        $sortie3-> setDuree(30);
        $sortie3-> setDateLimiteInscription(new \datetime("08-12-2021"));
        $sortie3-> setNbInscriptionsMax(7);
        $sortie3-> setInfosSortie("A nous le grand saut en parachute, nous convions 14 participants mais nous possedons seulement 10 parachutes, ATTENTION vous etes obligé de sauter");
        $sortie3-> setCampus($campus3);
        $sortie3-> setEtat($etat2);
        $sortie3->setLieu($lieu3);
        $sortie3-> setOrganisateur($participant4);
        $manager->persist($sortie3);
        $manager->flush();

        $sortie4 = new Sortie();
        $sortie4-> setNom("Croquer la Pomme.");
        $sortie4-> setDateHeureDebut(new \datetime("14-12-2021"));
        $sortie4-> setDuree(10);
        $sortie4-> setDateLimiteInscription(new \datetime("14-12-2021"));
        $sortie4-> setNbInscriptionsMax(10);
        $sortie4-> setInfosSortie("Rien de tel que de se faire plaisir avant Noël, plein de cadeaux sont à remporter, à condition de croquer la pomme. Le jeu se deroule par équipes de 2 minimum, un joueur met une pomme sur sa tête et l'autre joueur a 3 couteaux. Si après avoir lancé ses couteaux le joueur a touché la pomme, il remporte un cadeau. Sinon c'est perdu !!");
        $sortie4-> setCampus($campus4);
        $sortie4-> setEtat($etat1);
        $sortie4->setLieu($lieu4);
        $sortie4-> setOrganisateur($participant2);
        $manager->persist($sortie4);
        $manager->flush();

        $sortie5 = new Sortie();
        $sortie5-> setNom("Sortie à la plage.");
        $sortie5-> setDateHeureDebut(new \datetime("14-08-2021"));
        $sortie5-> setDuree(10);
        $sortie5-> setDateLimiteInscription(new \datetime("12-08-2021"));
        $sortie5-> setNbInscriptionsMax(10);
        $sortie5-> setInfosSortie("Fait trop chaud let's go to the beach, las Sandias!!");
        $sortie5-> setCampus($campus5);
        $sortie5-> setEtat($etat5);
        $sortie5->setLieu($lieu5);
        $sortie5-> setOrganisateur($participant2);
        $manager->persist($sortie5);
        $manager->flush();

        $sortie6 = new Sortie();
        $sortie6-> setNom("Sortie Cinema.");
        $sortie6-> setDateHeureDebut(new \datetime("03-10-2021"));
        $sortie6-> setDuree(10);
        $sortie6-> setDateLimiteInscription(new \datetime("01-10-2021"));
        $sortie6-> setNbInscriptionsMax(10);
        $sortie6-> setInfosSortie("Le dernier StarWars est sorti au cinéma !!!");
        $sortie6-> setCampus($campus3);
        $sortie6-> setEtat($etat5);
        $sortie6->setLieu($lieu3);
        $sortie6-> setOrganisateur($participant3);
        $manager->persist($sortie6);
        $manager->flush();

    }
}
