<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\EtatRepository;
use App\Repository\LieuRepository;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Response;
use Symfony\Component\HttpFoundation\Request;
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
            // on récupère l'objet participant
            $organisateur = $this->getUser();
            // on hydrate (affecter) notre organisateur à la sortie.
            $newSortie->setOrganisateur($organisateur);
            // on récupère l'objet campus
            $campus = $this->getUser()->getCampus();
            // on hydrate (affecter) notre ampus à la sortie.
            $newSortie->setCampus($campus);
            // on définie l'état en dure dans notre sortie.
            $newSortie->setEtat($repoEtat->findOneBy(['id'=>47]));
            $em->persist($newSortie);
            $em->flush();
            // do anything else you need here, like send an email

            $this->addFlash('success', 'La sortie a bien été ajoutée.');
            return $this->redirectToRoute('sortie_ajouter');
        }

        return $this->renderForm('sortie/ajouter.html.twig',
        compact("formSortie",'newSortie', 'campus'));
    }

    /**
     * @Route("/liste", name="_liste")
     */
    public function AfficherListeSorties(SortieRepository $repo)
    {
        $listeSorties = $repo->findAll();

        return $this->render('sortie/liste.html.twig', compact('listeSorties'));
    }
}