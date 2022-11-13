<?php

namespace App\Controller;

use App\Entity\Noticias;
use App\Form\NoticiasType;
use App\Repository\NoticiasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/noticias')]
class NoticiasController extends AbstractController
{
    #[Route('/', name: 'app_noticias_index', methods: ['GET'])]
    public function index(NoticiasRepository $noticiasRepository): Response
    {
        return $this->render('noticias/index.html', [
            'noticias' => $noticiasRepository->findAllOrderedByFecha(),
        ]);
    }

    #[Route('/redireccion', name: 'app_redic_index' )]
    public function rec(): Response
    {
        return $this->render('logout/logout.html.twig');
    }

    #[Route('/new', name: 'app_noticias_new', methods: ['GET', 'POST'])]
    public function new(Request $request, NoticiasRepository $noticiasRepository, ManagerRegistry $doctrine, SluggerInterface $slugger): Response
    {
        $noticia = new Noticias();
        $form = $this->createForm(NoticiasType::class, $noticia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $brochureFile = $form['foto']->getData();
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('fotos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new \Exception('¡Uy!, algo salió mal! :(');
                }

                $noticia->setFoto($newFilename);
            }
                $user = $this->getUser();
                $noticia->setUser($user);
                $em = $doctrine->getManager();
                $em->persist($noticia);
                $em->flush();

                $noticiasRepository->save($noticia, true);

            $noticiasRepository->save($noticia, true);

            return $this->redirectToRoute('app_noticias_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('noticias/new.html.twig', [
            'noticia' => $noticia,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_noticias_show', methods: ['GET'])]
    public function show(Noticias $noticia): Response
    {
        return $this->render('noticias/show.html.twig', [
            'noticia' => $noticia,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_noticias_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Noticias $noticia, NoticiasRepository $noticiasRepository): Response
    {
        $form = $this->createForm(NoticiasType::class, $noticia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $noticiasRepository->save($noticia, true);

            return $this->redirectToRoute('app_noticias_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('noticias/edit.html.twig', [
            'noticia' => $noticia,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_noticias_delete', methods: ['POST'])]
    public function delete(Request $request, Noticias $noticia, NoticiasRepository $noticiasRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$noticia->getId(), $request->request->get('_token'))) {
            $noticiasRepository->remove($noticia, true);
        }

        return $this->redirectToRoute('app_noticias_index', [], Response::HTTP_SEE_OTHER);
    }
}
