<?php
namespace App\Controller;

use App\Repository\TareaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TareasController extends AbstractController{


    #[Route("/tareas")]
    public function start(TareaRepository $tareaRepository, Request $request){
       $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");
       $filtro = $request->request->get("filtro");
        $orden = $request->request->get("orden");

        $usuario = $this->getUser();

        // var_dump($usuario->getTareas());

        $tareas = $tareaRepository->filtrar($usuario, $filtro, $orden);

        return $this->render("tareas.html.twig", ["tareas"=> $tareas]);

    }
    
}