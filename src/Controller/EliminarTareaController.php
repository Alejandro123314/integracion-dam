<?php
namespace App\Controller;

use App\Repository\TareaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EliminarTareaController extends AbstractController{
    #[Route("/tareas/eliminar/{id}")]
    public function start(int $id, TareaRepository $tareaRepository){
        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");
        $tarea = $tareaRepository->find($id);
        if($tarea){
            $tareaRepository->remove($tarea, true);
        }
        // return $this->redirect('/tareas');
       return $this->redirectToRoute('app_tareas_start');
    }
}