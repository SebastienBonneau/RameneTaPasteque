<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
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
        Request $request

        ): \Symfony\Component\HttpFoundation\Response
    {
        $newSortie = new Sortie();
        /* TODO ajouter les champs écrits en dur dans le formulaire et récupérérés selon organisateur de la sortie et lieu choisi
        $campus = $newSortie->getOrganisateur($newSortie)->getCampus($newSortie);
        $rue = $newSortie->getLieu($newSortie)->getRue($newSortie);
        $codePostal = $newSortie->getLieu($newSortie)->getVille($newSortie)->getCodePostal($newSortie);
        $newSortie->setCampus($campus);
        $newSortie->setLieu($newSortie->getRue());
        $newSortie->getLieu($newSortie)->getVille($newSortie)->setCodePostal($codePostal);
        */
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
        compact("formSortie"));
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