<?php

namespace App\Controller;

use App\Entity\Repas;
use App\Form\Repas1Type;
use App\Repository\RepasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/repas")
 */
class RepasController extends AbstractController
{
    /**
     * @Route("/", name="repas_index", methods={"GET"})
     */
    public function index(RepasRepository $repasRepository): Response
    {
        return $this->render('repas/index.html.twig', [
            'repas' => $repasRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="repas_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $repa = new Repas();
        $form = $this->createForm(Repas1Type::class, $repa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($repa);
            $entityManager->flush();

            return $this->redirectToRoute('repas_index');
        }

        return $this->render('repas/new.html.twig', [
            'repa' => $repa,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="repas_show", methods={"GET"})
     */
    public function show(Repas $repa): Response
    {
        return $this->render('repas/show.html.twig', [
            'repa' => $repa,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="repas_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Repas $repa): Response
    {
        $form = $this->createForm(Repas1Type::class, $repa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('repas_index');
        }

        return $this->render('repas/edit.html.twig', [
            'repa' => $repa,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="repas_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Repas $repa): Response
    {
        if ($this->isCsrfTokenValid('delete'.$repa->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($repa);
            $entityManager->flush();
        }

        return $this->redirectToRoute('repas_index');
    }
}
