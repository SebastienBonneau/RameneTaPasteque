<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use App\Form\AnnulerSortieType;
use App\Form\LieuType;
use App\Form\ModifierSortieType;
use App\Form\SortieType;
use App\Form\VilleType;
use App\Repository\CampusRepository;
use App\Repository\EtatRepository;
use App\Repository\LieuRepository;
use App\Repository\SortieRepository;
use App\Repository\VilleRepository;
use App\Services\Service;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sortie", name="sortie")
 */
class SortieController extends AbstractController
{

    /**
     * @Route("/ajouter", name="_ajouter")
     */
    public function ajouter(
        EntityManagerInterface $em,
        Request $request,
        LieuRepository $repoL,
        EtatRepository $repoEtat

        ): Response
    {
        // Infos pour que le formulaire ajouter lieu soit accessible sur le formulaire de
        // création d'une sortie
        $lieu = new Lieu();
        $formLieu = $this->createForm(LieuType::class, $lieu);
        // le handle request pour ce formulaire sera fait directement dans la fonction : ajouterLieu
        // de ce SortieController
        // le $formLieu sera envoyé dans le compact du renderForm en fin de fonction sortie_ajouter

        // Infos pour que le formulaire ajouter ville soit accessible sur le formulaire de
        // création d'une sortie
        $ville = new Ville();
        $formVille = $this->createForm(VilleType::class, $ville);
        // le handle request pour ce formulaire sera fait directement dans la fonction : ajouterVille
        // de ce SortieController
        // le $formVille sera envoyé dans le compact du renderForm en fin de fonction sortie_ajouter

        // création d'une nouvelle sortie
        $newSortie = new Sortie();
        // récupération du campus associé à la $newSortie via l'organisateur que l'on affecte à $newSortie
        $campus = $this->getUser()->getCampus();
        $formSortie = $this->createForm(SortieType::class, $newSortie);
        $formSortie->handleRequest($request);
        if ($formSortie->isSubmitted() && $formSortie->isValid()) {
            // on récupère l'id du lieu
            $lieuId = $request->get('lieu');
            $lieu = $repoL->find($lieuId);
            $newSortie->setLieu($lieu);
            // on récupère l'objet participant (qui est l'organisateur de la sortie)
            // grâce à getUser qui récupère l'user (=participant connecté)
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
        compact("formSortie",'newSortie', 'campus', 'formLieu', 'formVille'));
    }

    //------------------------------------

    /**
     * @Route("/ajouterLieu", name="_ajouterLieu")
     */
    public function ajouterLieu(
        EntityManagerInterface $em,
        VilleRepository $repoV,
        Request $request
    ): Response
    {
        // création d'un nouveau lieu
        $newLieu = new Lieu();
        $formLieu = $this->createForm(LieuType:: class, $newLieu);
        $formLieu->handleRequest($request);
        $em->persist($newLieu);
        $em->flush();
        return $this->redirectToRoute('sortie_ajouter');
    }

    //------------------------------------

    /**
     * @Route("/ajouterVille", name="_ajouterVille")
     */
    public function ajouterVille(
        EntityManagerInterface $em,
        Request $request
    ): Response
    {
        // création d'un nouveau lieu
        $newVille = new Ville();
        $formVille = $this->createForm(VilleType:: class, $newVille);
        $formVille->handleRequest($request);
        $em->persist($newVille);
        $em->flush();
        return $this->redirectToRoute('sortie_ajouter');
    }

    //------------------------------------

    /**
     * @Route("/liste", name="_liste")
     */
    public function liste(CampusRepository $repoC)
    {
        return $this->render('sortie/liste.html.twig',
            [ 'campus'=>$repoC->findAll()]);
    }

    //------------------------------------

    /**
     * @Route("/api/liste/", name="_api_liste")
     */
    public function apiListe(
        SortieRepository $repo,
        Service $service

        ): Response
    {
        $listeSorties = $repo->findByDate();
        $tableau = [];

        //Boucle for each pour récupérer tout ce qu'il y a dans le tableau
            foreach ($listeSorties as $sortie){
                // On crée une variable de type booléen pour récupérer l'info si l'user connecté
                // est inscrit ou pas ==> On fait appel à notre injection de dépendance Service
                // pour appliquer la méthode qui y est définie (verifInscription et qui utilise
                // en paramètres (participants de sortie et l'user connecté)
                // C'est ce qui permettra de gérer l'affichage de la colonne 'inscrit' dans le tableau
                // du twig liste
                $maDateInscription = $sortie->getDateLimiteInscription(); // je crée une variable pour la date pour pouvoir la formater comme je veux sans influencer sur mon fichier JS qui recupere la meme date.
                $maDateDebut = $sortie->getDateHeureDebut();
                $userInscrit = $service->verifInscription($sortie->getParticipants(),$this->getUser());
                $userOrganisateur = $service->verifUserConnectedOrganisateur($sortie->getOrganisateur(),$this->getUser());

                $tab['id']= $sortie->getId();
                $tab['nom']= $sortie->getNom();
                $tab['dateHeureDebut']= $maDateDebut->format('d/m/Y H:i'); // permets de formater le dateTime en date seulement et comme on veut.
                $tab['dateHeureDebut3']= $maDateDebut; // variable date crée pour notre JS pour comparer dates
                $tab['dateLimiteInscription']= $maDateInscription->format('d/m/Y H:i');
                $tab['dateLimiteInscription2']= $maDateInscription; // variable date crée pour notre JS pour comparer dates
                $tab['nbInscription']= count($sortie->getParticipants());
                $tab['nbInscriptionsMax']= $sortie->getNbInscriptionsMax();
                $tab['etat']= $sortie->getEtat()->getLibelle();
                $tab['userInscrit'] = $userInscrit;
                $tab['organisateur']= $sortie->getOrganisateur()->getPrenom();
                $tab['organisateurId']= $sortie->getOrganisateur()->getId();
                $tab['userOrganisateur'] = $userOrganisateur;
                $tab['campus'] = $sortie->getCampus()->getId();

                $tableau[]= $tab;
            }
        return $this->json($tableau);
    }

    //------------------------------------

    /**
     * @Route("/inscription/{exit}", name="_inscription")
     */
    public function inscription(
        Sortie $exit,
        EntityManagerInterface $em,
        Service $service

    ): Response
    {
        $maDate = new \DateTime();
        $verif = $service->verifInscription($exit->getParticipants(),$this->getUser());
        $SommeParticipants = count($exit->getParticipants());
        if( $exit->getDateLimiteInscription() > $maDate && $exit->getNbInscriptionsMax() > $SommeParticipants && $verif == false && $exit->getEtat() == 'ouverte')
        {
           $exit->addParticipant($this->getUser());
           $em->persist($exit);
           $em->flush();
           $this->addFlash('success', 'Votre participation a bien été prise en compte.');
        }else
        {
           $this->addFlash('echec', 'Inscription impossible... Choisissez une autre sortie !');
        }
        return $this->redirectToRoute('sortie_liste');
    }

    //------------------------------------

    /**
     * @Route("/seDesinscrire/{exit}", name="_seDesinscrire")
     */
    public function seDesinscrire(
        Sortie $exit,
        EntityManagerInterface $em,
        Service $service

    ): Response
    {
        $maDate = new \DateTime();
        $verif = $service->verifInscription($exit->getParticipants(),$this->getUser());

        if( $exit->getDateHeureDebut() > $maDate && $verif == true)
        {
            $exit->removeParticipant($this->getUser());
            $em->persist($exit);
            $em->flush();
            $this->addFlash('success', 'Votre désistement a bien été pris en compte.');
        }else
        {
            $this->addFlash('echec', 'Impossible de se désister... Sortie en cours ou passée !! ');
        }
        return $this->redirectToRoute('sortie_liste');
    }

    //------------------------------------

    /**
     * @Route("/detail/{sortie}", name="_detail")
     */
    public function detail(Sortie $sortie): Response
    {
        return $this->render('sortie/detail.html.twig',
            compact("sortie")
        );
    }

    //------------------------------------

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

    //------------------------------------

    /**
     * @Route("/modifier/{sortie}", name="_modifier")
     */
    public function modifier(
        Sortie $sortie,
        EntityManagerInterface $em,
        Request $request,
        LieuRepository $repoL,
        EtatRepository $repoEtat
    ): Response
    {
        // récupération du campus associé à la $newSortie via l'organisateur que l'on affecte à $newSortie

        $formModifS = $this->createForm(ModifierSortieType::class, $sortie);
        $formModifS->handleRequest($request);
        if ($formModifS->isSubmitted() && $formModifS->isValid()) {
            $publier = $request->get('publier');
            $annuler = $request->get('annuler');
            if ($publier == 1){
                $sortie->setEtat($repoEtat->findOneBy(['id' => 2]));
            }
            if ($annuler == 1){
                $sortie->setEtat($repoEtat->findOneBy(['id' => 6]));
                $em->flush();

                $this->addFlash('success', 'La sortie a bien été annulée.');
                return $this->redirectToRoute('sortie_liste');
            }

            $em->flush();
            $this->addFlash('success', 'La sortie a bien été modifiée.');
            return $this->redirectToRoute('sortie_liste');
        }
        return $this->renderForm('sortie/modifier.html.twig',
            compact("formModifS",'sortie'));
    }

    //------------------------------------

    /**
     * @Route("/annuler/{sortie}", name="_annuler")
     */
    public function annuler(
        Sortie $sortie,
        EntityManagerInterface $em,
        EtatRepository $repoEtat,
        Request $request,

    ): Response
    {
        // création du formulaire pour la sortie à annuler
        $formAnnuler = $this->createForm(AnnulerSortieType::class, $sortie);

        $formAnnuler->handleRequest($request);
        if ($formAnnuler->isSubmitted() && $formAnnuler->isValid()) {

            // Dans la BDD, je donne à la variable sortie l'état "annulée" ==> id =6
            $sortie->setEtat($repoEtat->findOneBy(['id' => 6]));
            // je mets à jour avec cette valeur
            //$em->persist($sortieAannuler);
            // j'envoie en BDD
            $em->flush();
            $this->addFlash('success', 'La sortie a bien été annulée.');
            return $this->redirectToRoute('sortie_liste');
        }
        return $this->renderForm('sortie/annuler.html.twig',
            compact('formAnnuler', 'sortie'));
    }

    //------------------------------------

    /**
     * @Route("/api/ville-lieu/", name="_api_ville-lieu")
     */
    public function api(VilleRepository $repoV,LieuRepository $repoL): Response
    {
        $villes = $repoV->findAll();
        $tab_ville = [];
        foreach ($villes as $v)
        {
            $info_v['id'] = $v->getId();
            $info_v['nom'] = $v->getNom();
            $info_v['codePostal'] = $v->getCodePostal();
            $tab_ville[] = $info_v;
        }
        $lieux = $repoL->findAll();
        $tab_lieu = [];
        foreach ($lieux as $l)
        {
            $info_l['id'] = $l->getId();
            $info_l['nom'] = $l->getNom();
            $info_l['rue'] = $l->getRue();
            $info_l['latitude']  = $l->getLatitude();
            $info_l['longitude']  = $l->getLongitude();
            $info_l['ville'] = $l->getVille()->getId();
            $tab_lieu[] = $info_l;
        }
        $tab['villes'] = $tab_ville;
        $tab['lieux'] = $tab_lieu;
        return $this->json($tab);
    }

}