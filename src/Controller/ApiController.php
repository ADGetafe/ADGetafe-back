<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Noticias;
use App\Repository\NoticiasRepository;

 
class ApiController extends AbstractController
{

    #[Route('/api', name: 'api_index', methods: ["GET"])]
    public function index(ManagerRegistry $doctrine): Response
    {
        $proyectos = $doctrine
            ->getRepository(Noticias::class)
            ->findAll();
   
        $data = array();
        
        foreach ($proyectos as $proyecto) {
            $data[] = [
                'id' => $proyecto->getId(),
                'categoria_noticia' => $proyecto->getCategoria(),
                'titulo_noticia' => $proyecto->getTitulo(),
                'autoria_noticia' => $proyecto->getAutor(),
                'actualizacion_noticia' => $proyecto->getCreatedAt(),
                'creacion_noticia' => $proyecto->getUpdatedAt(),
                'articulo_noticia' => $proyecto->getArticulo(),
            ];
         }

        $datanueva =  json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        $response = new Response($datanueva);
        $response->headers->add([
            'Content-Type' => 'application/json',
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Headers' => '*',
            'Access-Control-Allow-Methods' => 'GET,OPTIONS',
            'Allow' => 'GET,OPTIONS',
            'cache-control' => 'no-cache,private',
            'connection' => 'Keep-Alive',
            'keep-alive' => 'timeout=5,max=98',

        ]);
        return $response;
        //return new JsonResponse($data, Response::HTTP_OK);
    }

   
}