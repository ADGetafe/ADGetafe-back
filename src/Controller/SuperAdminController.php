<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class SuperAdminController extends AbstractController
{
    #[Route('/dashboard', name: 'app_super_admin')]
    public function index(): Response
    {
        return $this->render('super_admin/index.html.twig', [
            'controller_name' => 'SuperAdminController',
        ]);
    }

    #[Route('/usuarios', name: 'usuarios', methods: ['GET'])]
    public function userList(UserRepository $userRepository): Response
    {
        return $this->render('super_admin/users.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/usuarios/editar/{id}', name: 'editar_usuarios')]
    public function editUser(Request $request, User $user)
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Usuario modificado exitosamente');
            return $this->redirectToRoute('usuarios');
        }
        return $this->render('super_admin/edit.html.twig',[
            'userForm' => $form->createView(),
        ]);
    }

    // #[Route('/usuarios/eliminar/{id}', name: 'eliminar_usuarios', methods:['GET','DELETE'])]
    // public function deleteUser($id):Response
    // {
    //     $user = $this->getDoctrine()->getRepository(UserRepository::class)->find($id);
        
    //     $em=$this->gerDoctrine()->getManager();
    //     $em->remove($user);
    //     $em->flush();
    //     // $this->em->remove($user);
    //     // $this->em->flush();

    //     return $this->redirectToRoute('usuarios');
    // }

    #[Route('/{id}', name: 'eliminar_usuarios', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('usuarios', [], Response::HTTP_SEE_OTHER);
    }
}
