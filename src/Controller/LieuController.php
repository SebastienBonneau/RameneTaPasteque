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
     * @Route("/ajouter", name="_ajouter")
     */
    public function ajouter(
        EntityManagerInterface $em,
        Request                $request
    ): Response
    {
        // création d'un nouveau lieu
        $newLieu = new Lieu();

        $formLieu = $this->createForm(LieuType:: class, $newLieu);

        $formLieu->handleRequest($request);

        $em->persist($newLieu);
        $em->flush();

        //$this->addFlash('success', 'Le lieu a bien été ajouté.');
        return $this->redirectToRoute('sortie_ajouter');

    }
}

