<?php
namespace App\Controller;

use App\Entity\Metier;
use App\Form\MetierType;
use App\Repository\MetierRepository;
use App\Repository\TypePrestationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use App\Form\TypePrestationType;
use App\Entity\TypePrestation;
use App\Form\MetierTypePrestationType;
use App\Entity\MetierTypePrestation;

/**
 *
 * @Route("/admin/metier")
 */
class MetierController extends AbstractController
{
    
    /**
     *
     * @Route("/", name="metier_index", methods={"GET"})
     */
//    public function index(MetierRepository $metierRepository): Response
    public function index(MetierRepository $metierRepository): Response
    
    {
        return $this->render('metier/index.html.twig', [
            'metiers' => $metierRepository->findAll()
        ]);
    }

    /**
     *
     * @Route("/new", name="metier_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $metier = new Metier();
        $form = $this->createForm(MetierType::class, $metier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($metier);
            $entityManager->flush();

            return $this->redirectToRoute('metier_index');
        }

        return $this->render('metier/new.html.twig', [
            'metier' => $metier,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/{id}", name="metier_show", methods={"GET"})
     */
    public function show(Metier $metier): Response
    {
        return $this->render('metier/show.html.twig', [
            'metier' => $metier
        ]);
    }

    /**
     *
     * @Route("/{id}/edit", name="metier_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Metier $metier): Response
    {
        $form = $this->createForm(MetierType::class, $metier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()
                ->getManager()
                ->flush();

            return $this->redirectToRoute('metier_index', [
                'id' => $metier->getId()
            ]);
        }

        return $this->render('metier/edit.html.twig', [
            'metier' => $metier,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/{id}", name="metier_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Metier $metier): Response
    {
        if ($this->isCsrfTokenValid('delete' . $metier->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($metier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('metier_index');
    }

    /**
     *
     * @Route("/{id}/add/typeprestation", name="metier_add_typeprestation", methods={"GET","POST"})
     */
    public function addTypePrestation(Request $request, Metier $metier, TypePrestationRepository $typePrestationRepository): Response
    {
        $metierTypePrestation = new MetierTypePrestation($typePrestationRepository);
        $metierTypePrestation->setMetier($metier);
//        $metierTypePrestation->setTypePrestation($typePrestation);
        $form = $this->createForm(MetierTypePrestationType::class, $metierTypePrestation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $metier->addtypePrestation($metierTypePrestation->getTypePrestation());
            $entityManager->persist($metier);
            $entityManager->flush();
return $this->show($metier);
// return $this->redirectToRoute('metier_show',$metier->getId());
        }

        return $this->render('metier/addTypePrestation.html.twig', [
            'metier' => $metier,
            'form' => $form->createView()
        ]);
    }
    /**
     *
     * @Route("/{id}/del/type/prestation/{idt}", name="metier_del_typeprestation", methods={"DELETE"})
     * @Entity("typePrestation", expr="repository.find(idt)")
     */
    public function removeTypePrestation(Request $request, Metier $metier, TypePrestation $typePrestation): Response
    {
        if ($this->isCsrfTokenValid('delete typeprestation' . $typePrestation->getId(), $request->request->get('_token'))) {
            $metier->removetypePrestation($typePrestation);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
        }
        return $this->show($metier);
//        return $this->redirectToRoute('metier_show',$metier->getId());
    }
}
