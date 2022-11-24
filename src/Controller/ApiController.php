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
use App\Entity\Revistas;
use App\Repository\RevistasRepository;

 
class ApiController extends AbstractController
{

    #[Route('/not', name: 'api_index', methods: ["GET"])]
    public function index( ManagerRegistry $doctrine, Request $request): Response
    {
        $proyectos = $doctrine
            ->getRepository(Noticias::class)
            ->findAllOrderedByFecha();
   
        $data = array();
        
        foreach ($proyectos as $proyecto) {
            $data[] = [
                'id' => $proyecto->getId(),
                'categoria_noticia' => $proyecto->getCategoria(),
                'imagen_noticia'=>'https://127.0.0.1:8000/uploads/fotos/'.$proyecto->getFoto(),
                'titulo_noticia' => $proyecto->getTitulo(),
                'autoria_noticia' => $proyecto->getAutor(),
                'actualizacion_noticia' => $proyecto->getCreatedAt(),
                'creacion_noticia' => $proyecto->getUpdatedAt(),
                'articulo_noticia' => $proyecto->getArticulo(),
                'fragmento_noticia' => $proyecto->getFragmento(),
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
        return new JsonResponse($data, Response::HTTP_OK);
    }

    //api por id

    #[Route('/news_api/{id}', name: 'api_index_id', methods: ["GET"])]
    public function notciacias_api_id( int $id, ManagerRegistry $doctrine, Request $request): Response
    {
        $id_api = $doctrine
            ->getRepository(Noticias::class)
            ->findBy([ 'id'=> $id ]);

        $data = array();
        
        foreach ($id_api as $id_news_api) {
            $data[] = [
                'id' => $id_news_api->getId(),
                'categoria_noticia' => $id_news_api->getCategoria(),
                'imagen_noticia'=>'https://127.0.0.1:8000/uploads/fotos/'.$id_news_api->getFoto(),
                'titulo_noticia' => $id_news_api->getTitulo(),
                'autoria_noticia' => $id_news_api->getAutor(),
                'creacion_noticia' => $id_news_api->getUpdatedAt(),
                'articulo_noticia' => $id_news_api->getArticulo(),
                'fragmento_noticia' => $id_news_api->getFragmento(),
            ];
         }

        $new_api_id_data =  json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        $response = new Response($new_api_id_data);
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
        return new JsonResponse($new_api_id_data, Response::HTTP_OK);
    }


    //revistas api

    #[Route('/rev', name: 'api_revistas', methods: ["GET"])]
    public function api_revistas(ManagerRegistry $doctrine, Request $request): Response
    {
        $proyectos = $doctrine
            ->getRepository(Revistas::class)
            ->findAllOrderedByFecha();

        foreach ($proyectos as $proyecto) {

        $data[] = [
            'id' => $proyecto->getId(),
            'titulo_revista' => $proyecto->getTitulo(),
            'revista_revista'=>'https://127.0.0.1:8000/uploads/revistas/'.$proyecto->getRevista(),
            'fragmento_revista' => $proyecto->getFragmento(),
            ];
        }
        // return $this->json($data, $status = 200, $headers = ['Access-control-Allow-Origin'=>'*']);
        
        // //fin

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
        return new JsonResponse($data, Response::HTTP_OK);
    }

   
}