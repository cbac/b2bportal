<?php

namespace App\Controller;

use App\Entity\Metier;
use App\Entity\Partenaire;
use App\Form\CatalogueType;
use App\Form\PartenaireType;
use App\Repository\PartenaireRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\AddMetierType;
use App\Entity\Catalogue;
use App\Repository\MetierRepository;
use App\Entity\PartenaireMetier;

/**
 * @Route("/partenaire")
 */
class PartenaireController extends AbstractController
{

    /**
     * @Route("/", name="partenaire_index", methods={"GET"})
     */
    public function index(PartenaireRepository $partenaireRepository): Response
    {
        return $this->render('partenaire/index.html.twig', [
            'partenaires' => $partenaireRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="partenaire_new", methods={"GET","POST"})
     */
    public function new(Request $request,  UserPasswordEncoderInterface $encoder ): Response
    {
        $partenaire = new Partenaire();
        $form = $this->createForm(PartenaireType::class, $partenaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($partenaire->getLocalisation());
            //crypt password 
            $user= $partenaire->getUser();
            $password = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            // Set their role
            $user->setRole('ROLE_USER');
            $entityManager->persist($user);
            $localisation = $partenaire->getLocalisation();
            $localisation->calculateLatLon();
            $entityManager->persist($partenaire);
            $entityManager->flush();

            return $this->redirectToRoute('partenaire_index');
        }

        return $this->render('partenaire/new.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="partenaire_show", methods={"GET"})
     */
    public function show(Partenaire $partenaire): Response
    {        
        return $this->render('partenaire/show.html.twig', [
            'partenaire' => $partenaire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="partenaire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Partenaire $partenaire): Response
    {
        $form = $this->createForm(PartenaireType::class, $partenaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $localisation = $partenaire->getLocalisation();
            $localisation->calculateLatLon();
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('partenaire_index', [
                'id' => $partenaire->getId(),
            ]);
        }

        return $this->render('partenaire/edit.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="partenaire_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Partenaire $partenaire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$partenaire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($partenaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('partenaire_index');
    }
    /**
     *
     * @Route("/{id}/add/catalogue", name="partenaire_add_catalogue", methods={"GET","POST"})
     */
    public function addCatalogue(Request $request, Partenaire $partenaire): Response
    {
        $catalogue = new Catalogue();
        $form = $this->createForm(CatalogueType::class, $catalogue);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $partenaire->addCatalogue($catalogue);
            $entityManager->persist($catalogue);
            $entityManager->persist($partenaire);
            $entityManager->flush();
            return $this->show($partenaire);
       //     return $this->redirectToRoute('metier_index');
        }
        
        return $this->render('partenaire/addCatalogue.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form->createView()
        ]);
    }
    /**
     *
     * @Route("/{id}/del/catalogue/{idc}", name="partenaire_delete_catalogue", methods={"DELETE"})
     * @Entity("partenaire", expr="repository.find(id)")
     * @Entity("catEntry", expr="repository.find(idc)")
     */
    public function removeCatalogue(Request $request, Partenaire $partenaire, Catalogue $catEntry): Response
    {
        if ($this->isCsrfTokenValid('partenaire_delete_catalogue'.$partenaire->getId().$catEntry->getId(), $request->request->get('_token'))) {
            $partenaire->removeCatalogue($catEntry);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
        }
        return $this->show($partenaire);
        //        return $this->redirectToRoute('metier_show',$metier->getId());
    }
    /**
     *
     * @Route("/{id}/add/metier", name="partenaire_add_metier", methods={"GET","POST"})
     */
    public function addMetier(Request $request, Partenaire $partenaire, MetierRepository $metierRepository): Response
    {
        $partenaireMetier = new PartenaireMetier($metierRepository);
        $partenaireMetier->setPartenaire($partenaire);
        $form = $this->createForm(AddMetierType::class,$partenaireMetier);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            
            $partenaire->addMetier($partenaireMetier->getMetier(), $entityManager);
            $entityManager->persist($partenaire);
            $entityManager->flush();
            return $this->show($partenaire);
            return $this->redirectToRoute('partenaire_show', [
                'id' => $partenaire->getId(),
            ]);
        }
        
        return $this->render('partenaire/addMetier.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form->createView()
        ]);
    }
    /**
     *
     * @Route("/{id}/del/metier/{idm}", name="partenaire_delete_metier", methods={"DELETE"})
     * @Entity("partenaire", expr="repository.find(id)")
     * @Entity("metier", expr="repository.find(idm)")
     */
    public function removeMetier(Request $request, Partenaire $partenaire, Metier $metier): Response
    {
        if ($this->isCsrfTokenValid('partenaire_delete_metier'.$partenaire->getId().$metier->getId(), $request->request->get('_token'))) {
            $partenaire->removeMetier($metier);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
        }
        return $this->show($partenaire);
        //        return $this->redirectToRoute('metier_show',$metier->getId());
    }
}
