<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Form\TypePrestationType;
use App\Repository\EtatRepository;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\TypePrestation;

/**
 * @Route("/evenement")
 */
class EvenementController extends AbstractController
{
    /**
     * @Route("/", name="evenement_index", methods={"GET"})
     */
    public function index(EvenementRepository $evenementRepository): Response
    {
        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="evenement_new", methods={"GET","POST"})
     */
    public function new(Request $request, EtatRepository $etatRepository): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $etat = $etatRepository->findOneBy(['current'=>0]);
            $evenement->setEtat($etat);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('evenement_index');
        }

        return $this->render('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evenement_show", methods={"GET"})
     */
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="evenement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Evenement $evenement): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evenement_index', [
                'id' => $evenement->getId(),
            ]);
        }

        return $this->render('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }
    /**
     *
     * @Route("/{ide}/add/typeprestation", name="evenement_add_typeprestation", methods={"GET","POST"})
     * @Entity("Evenement", expr="repository.find(ide)")
     */
    
    public function addTypePrestation(Request $request, Evenement $evenement): Response
    {
        $typePrestation = new TypePrestation();
        $form = $this->createForm(TypePrestationType::class, $typePrestation);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $evenement->addTypePrestation($typePrestation);
            $entityManager->persist($typePrestation);
            $entityManager->persist($evenement);
            $entityManager->flush();
            return $this->show($typePrestation);
            //     return $this->redirectToRoute('metier_index');
        }
        
        return $this->render('evenement/addTypePrestation.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView()
        ]);
    }
    /**
     *
     * @Route("/{ide}/del/typeprestation/{idp}", name="evenement_delete_typeprestation", methods={"DELETE"})
     * @Entity("Evenement", expr="repository.find(ide)")
     * @Entity("TypePrestation", expr="repository.find(idp)")
     */
    public function removeTypePrestation(Request $request, Evenement $evenement, TypePrestation $typePrestation): Response
    {
        if ($this->isCsrfTokenValid('evenement_delete_type_prestation'.$evenement->getId().$typePrestation->getId(), $request->request->get('_token'))) {
            $evenement->removeTypePrestation($typePrestation);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
        }
        return $this->show($evenement);
        //        return $this->redirectToRoute('evenement_show',$evenement->getId());
    }
    /**
     * @Route("/{id}", name="evenement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Evenement $evenement): Response
    {
        if ($this->isCsrfTokenValid('evenement_delete'.$evenement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evenement_index');
    }
}
