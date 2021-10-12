<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ParticipantType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/Participant", name="participant")
 */
class ParticipantController extends AbstractController
{
    /**
     * @Route("/modifier/{id}", name="_modifier")
     */
    public function modifier(Participant $user, Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $form = $this->createForm(ParticipantType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $password = $form->get('plainPassword')->getData();
            if ($password) {
                $user->setPassword(
                    $userPasswordHasherInterface->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            // do anything else you need here, like send an email

            $this->addFlash('success', 'Le participant a bien été modifié.');
            return $this->redirectToRoute('app_participant_modifier');
        }

        return $this->render('participant/modifier.html.twig', [
            'participantForm' => $form->createView(),
        ]);
    }
}
