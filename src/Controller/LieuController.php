<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Form\LieuType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/lieu", name="lieu")
 */
class LieuController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{

    /**
     * @Route("/ajouterL", name="_ajouterL")
     */
    public function ajouterL(
        EntityManagerInterface $em,
        Request                $request
    ): Response
    {
        // création d'un nouveau lieu
        $newLieu = new Lieu();

        $formLieu = $this->createForm(LieuType:: class, $newLieu);

        $formLieu->handleRequest($request);
        if($formLieu->isSubmitted() && $formLieu->isValid())
        {
        $em->persist($newLieu);
        $em->flush();

        //$this->addFlash('success', 'Le lieu a bien été ajouté.');
        return $this->redirectToRoute('sortie_ajouter');
        }

    }
}

