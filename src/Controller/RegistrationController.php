<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user = new Participant();
        $user->setActif(true);
        $user->setPhoto('sandia.jpg');
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $admin = $form->get('administrateur')->getData();
            if ($admin){
                $user->setRoles(["ROLE_ADMIN"]);
                $user->setAdministrateur(true);
            }else{
                $user->setRoles(["ROLE_USER"]);
                $user->setAdministrateur(false);
            }
            $campus = $form->get('campus')->getData();
            $user->setCampus($campus);
            $user->setPassword(
            $userPasswordHasherInterface->hashPassword(
                    $user,
                    // pour récupérer une info détachée de l'entité (==> 'mapped'=> false dans le EntityTypeForm
                    $form->get('plainPassword')->getData()
                )

            );

            $entityManager = $this->getDoctrine()->getManager();// remplace injection de dépendance
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            $this->addFlash('success', 'Le participant a bien été ajouté.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

}
