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
     * @Route("/ajouter/{id}", name="_ajouter")
     */
    public function ajouter(
        EntityManagerInterface $em,
        Request $request,
        ParticipantRepository $repo,
        EtatRepository $repoEtat,
        LieuRepository $repoLieu,
        $id

        ): \Symfony\Component\HttpFoundation\Response
    {
        // récupération de l'organisateur de la sortie à parti de son id
        $organisateur = $repo->findOneBy(["id"=>$id]);

        // création d'une nouvelle sortie
        $newSortie = new Sortie();
        // récupération du campus associé à la $newSortie via l'organisateur que l'on affecte à $newSortie
        $newSortie->setCampus($organisateur->getCampus());
        // récupération de la rue de la sortie via le lieu, que l'on affecte à $newSortie
        $newSortie->setLieu($repoLieu->findOneBy(['id'=>$id]));
        $newSortie->setOrganisateur($organisateur);
        $newSortie->setEtat($repoEtat->findOneBy(['id'=>3]));
        $formSortie = $this->createForm(SortieType::class, $newSortie);

        $formSortie->handleRequest($request);

        if ($formSortie->isSubmitted() && $formSortie->isValid()) {

            $em->persist($newSortie);
            $em->flush();
            // do anything else you need here, like send an email

            $this->addFlash('success', 'La sortie a bien été ajoutée.');
            return $this->redirectToRoute('sortie_ajouter');
        }

        return $this->renderForm('sortie/ajouter.html.twig',
        compact("formSortie", 'organisateur','newSortie' ));
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