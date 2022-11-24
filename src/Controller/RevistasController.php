<?php

namespace App\Controller;

use App\Entity\Revistas;
use App\Form\RevistasType;
use App\Repository\RevistasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/revistas')]
class RevistasController extends AbstractController
{
    #[Route('/', name: 'app_revistas_index', methods: ['GET'])]
    public function index(RevistasRepository $revistasRepository): Response
    {
        return $this->render('revistas/index.html.twig', [
            'revistas' => $revistasRepository->findAllOrderedByFecha(),
        ]);
    }

    #[Route('/new', name: 'app_revistas_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RevistasRepository $revistasRepository, ManagerRegistry $doctrine, SluggerInterface $slugger): Response
    {
        $revista = new Revistas();
        $form = $this->createForm(RevistasType::class, $revista);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $brochureFile = $form['revista']->getData();
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('revistas_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new \Exception('¡Uy!, algo salió mal! :(');
                }

                $revista->setRevista($newFilename);
            }
                $em = $doctrine->getManager();
                $em->persist($revista);
                $em->flush();

                $revistasRepository->save($revista, true);

            $revistasRepository->save($revista, true);

            return $this->redirectToRoute('app_revistas_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('revistas/new.html.twig', [
            'revista' => $revista,
            'foto' => $revista,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_revistas_show', methods: ['GET'])]
    public function show(Revistas $revista): Response
    {
        return $this->render('revistas/show.html.twig', [
            'revista' => $revista,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_revistas_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Revistas $revista, RevistasRepository $revistasRepository): Response
    {
        $form = $this->createForm(RevistasType::class, $revista);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $revistasRepository->save($revista, true);

            return $this->redirectToRoute('app_revistas_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('revistas/edit.html.twig', [
            'revista' => $revista,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_revistas_delete', methods: ['POST'])]
    public function delete(Request $request, Revistas $revista, RevistasRepository $revistasRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$revista->getId(), $request->request->get('_token'))) {
            $revistasRepository->remove($revista, true);
        }

        return $this->redirectToRoute('app_revistas_index', [], Response::HTTP_SEE_OTHER);
    }
}
