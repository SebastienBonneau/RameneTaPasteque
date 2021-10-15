<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\EtatRepository;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use App\Services\Service;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sortie", name="sortie")
 */
class SortieController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    /**
     * @Route("/ajouter", name="_ajouter")
     */
    public function ajouter(
        EntityManagerInterface $em,
        Request $request,
        EtatRepository $repoEtat

        ): Response
    {
        // création d'une nouvelle sortie
        $newSortie = new Sortie();
        // récupération du campus associé à la $newSortie via l'organisateur que l'on affecte à $newSortie
        $campus = $this->getUser()->getCampus();

        $formSortie = $this->createForm(SortieType::class, $newSortie);

        $formSortie->handleRequest($request);

        if ($formSortie->isSubmitted() && $formSortie->isValid()) {
            // on récupère l'objet participant (qui est l'organisateur de la sortie)
            // grâce à getUser qui récupère l'user (=participant= connecté
            $organisateur = $this->getUser();
            // on hydrate (= on affecte) notre organisateur à la sortie.
            $newSortie->setOrganisateur($organisateur);
            // on récupère l'objet campus
            $campus = $this->getUser()->getCampus();
            // on hydrate (= on affecte) notre campus à la sortie.
            $newSortie->setCampus($campus);
            // on définit l'état en dur dans notre sortie (état créée avec id=1).
            $newSortie->setEtat($repoEtat->findOneBy(['id' => 1]));
            //je récupère l'info du bouton publier pour appliquer le traitement
            $publier = $request->get('publier');
            if ($publier == 1){
                $newSortie->setEtat($repoEtat->findOneBy(['id' => 2]));
            }
            $em->persist($newSortie);
            $em->flush();

            $this->addFlash('success', 'La sortie a bien été ajoutée.');
            return $this->redirectToRoute('sortie_ajouter');
        }

        return $this->renderForm('sortie/ajouter.html.twig',
        compact("formSortie",'newSortie', 'campus'));
    }

    /**
     * @Route("/liste", name="_liste")
     */
    public function liste()
    {
        //$listeSorties = $repo->findAll();

        return $this->render('sortie/liste.html.twig');//, compact('listeSorties'));
    }

    /**
     * @Route("/api/liste/", name="_api_liste")
     */
    public function apiListe(SortieRepository $repo, Service $service): Response
    {
        $listeSorties = $repo->findAll();
        $tableau = [];

        //Boucle for each pour récupérer tout ce qu'il y a dans le tableau
            foreach ($listeSorties as $sortie){
                // On crée une variable de type booléen pour récupérer l'info si l'user connecté
                // est inscrit ou pas ==> On fait appel à notre injection de dépendance Service
                // pour appliquer la méthode qui y est définie (verifInscription et qui utilise
                // en paramètres (participants de sortie et l'user connecté)
                // C'est ce qui permettra de gérer l'affichage de la colonne 'inscrit' dans le tableau
                // du twig liste
                //$userOrganisateur =$service->vérifUserConnectedOrganisateur($sortie->getOrganisateur()->getPrenom(), $this->getUser());
                //dd($userOrganisateur);
                $userInscrit = $service->verifInscription($sortie->getParticipants(),$this->getUser());
                $tab['id']= $sortie->getId();
                $tab['nom']= $sortie->getNom();
                $tab['dateHeureDebut']= $sortie->getDateHeureDebut();
                $tab['dateLimiteInscription']= $sortie->getDateLimiteInscription();
                $tab['nbInscriptionsMax']= $sortie->getNbInscriptionsMax();
                $tab['etat']= $sortie->getEtat()->getLibelle();
                $tab['userInscrit'] = $userInscrit;
                $tab['organisateur']= $sortie->getOrganisateur()->getPrenom();
                //$tab['userOrganisateur']= $userOrganisateur;

                $tableau[]= $tab;
            }

        return $this->json($tableau);
    }

    /**
     * @Route("/inscription/{exit}", name="_inscription")
     */
    public function inscription(
        Sortie $exit,
        EntityManagerInterface $em,

    ): Response
    {
//
        $exit->addParticipant($this->getUser());
        $em->persist($exit);
        $em->flush();


        $this->addFlash('success', 'Votre participation a bien ete prise en compte.');
        return $this->redirectToRoute('sortie_liste');

    }

    /**
     * @Route("/seDesinscrire/{exit}", name="_seDesinscrire")
     */
    public function seDesinscrire(
        Sortie $exit,
        EntityManagerInterface $em,

    ): Response
    {
//        $inscription = $sr->findOneBy(["id_participant" => $this->getUser()->getUserIdentifier()]);
        $exit->removeParticipant($this->getUser());
        $em->persist($exit);
        $em->flush();


        $this->addFlash('success', 'Nous avons bien pris en compte votre desistement.');
        return $this->redirectToRoute('sortie_liste');

    }

    /**
     * @Route("/detail/{sortie}", name="_detail")
     */
    public function detail(Sortie $sortie): Response
    {
        return $this->render('sortie/detail.html.twig',
            compact("sortie")
        );
    }

    /**
     * @Route("/publier/{sortie}", name="_publier")
     */
    public function publier(
        Sortie $sortie,
        EntityManagerInterface $em,
        EtatRepository $repoEtat
    ): Response
    {
        // Dans la BDD, je donne à la variable sortie l'état "ouverte" ==> id =2
        $sortie->setEtat($repoEtat->findOneBy(['id' => 2]));
        // je mets à jour avec cette valeur
        $em->persist($sortie);
        // j'envoie en BDD
        $em->flush();


        $this->addFlash('success', 'La sortie a bien été publiée.');
        return $this->redirectToRoute('sortie_liste');

    }

    /*
     * @Route("/annuler/{sortie}", name="_annuler")
     *
    public function annuler(
        Sortie $sortie,
        EntityManagerInterface $em,
        EtatRepository $repoEtat
    ): Response
    {
        // Dans la BDD, je donne à la variable sortie l'état "annulée" ==> id =6
        $sortie->setEtat($repoEtat->findOneBy(['id' => 6]));
        // je mets à jour avec cette valeur
        $em->persist($sortie);
        // j'envoie en BDD
        $em->flush();


        $this->addFlash('success', 'La sortie a bien été annulée.');
        return $this->redirectToRoute('sortie_liste');

    }*/
}