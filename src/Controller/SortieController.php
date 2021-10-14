<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
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

        ): \Symfony\Component\HttpFoundation\Response
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
            $newSortie->setEtat($repoEtat->findOneBy(['id'=>1]));

            $em->persist($newSortie);
            $em->flush();


            $this->addFlash('success', 'La sortie a bien été ajoutée.');
            return $this->redirectToRoute('sortie_ajouter');
        }

        return $this->renderForm('sortie/ajouter.html.twig',
        compact("formSortie",'newSortie', 'campus'));
    }

    /**
     * @Route("/api", name="_api")
     */
    public function api()
    {
        //$listeSorties = $repo->findAll();

        return $this->render('sortie/liste.html.twig');//, compact('listeSorties'));
    }

    /**
     * @Route("/api/liste", name="_api_liste")
     */
    public function apiListe(SortieRepository $repo): Response
    {
        $listeSorties = $repo->findAll();
        $tableau = [];
        //Boucle for each pour récupérer tout ce qu'il y a dans le tableau
            foreach ($listeSorties as $sortie){
                $tab['id']= $sortie->getId();
                $tab['nom']= $sortie->getNom();

                $tableau[]= $tab;

            }
        return $this->json($tableau);
    }
}