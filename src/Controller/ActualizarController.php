<?php
namespace App\Controller;

use Symfony\Component\Uid\Uuid;
use App\Repository\TareaRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ActualizarController extends AbstractController{
    #[Route("/tarea/actualizar/{id}")]
    public function start(int $id, TareaRepository $tareaRepository, Request $request){
        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");
        $tarea = $tareaRepository->find($id);
        if(!$tarea){
            
            return $this->redirectToRoute('app_tareas_start');
        }

        $titulo = $request->request->get("titulo");
        $descripcion = $request->request->get("descripcion");
        $prioridad = $request->request->get("prioridad");
        $completado = $request->request->get("completado");
        $fechaMaxima = $request->request->get("fechaMaxima");
        $recordatorio = $request->request->get("recordatorio");
        $fichero = $request->files->get("fichero");

        var_dump($fichero);

        if($fichero){
            $nombreFichero = Uuid::v4() . "." . $fichero->getClientOriginalExtension();
            $fichero->move($this->getParameter("files_directory"), $nombreFichero);
            $tarea->setFile($nombreFichero);
        }

        $tarea->setTitulo($titulo);
        $tarea->setDescripcion($descripcion);
        $tarea->setPrioridad($prioridad);

        if($completado == null){
            $completado = false;
        }
        $tarea->setCompletada($completado);

        $fechaM = $this->validarFecha($fechaMaxima);

        if($fechaM){
            $tarea->setFechaMaxima($fechaM);
        }

        $fechaR = $this->validarFecha($recordatorio);

        if($fechaR){
            $tarea->setRecordatorio($fechaR);
        }

        $tareaRepository->save($tarea,true);
        
       return $this->redirectToRoute('app_tarea_start',["id"=>$id]);
    }

    private function validarFecha($date){
        $d = DateTime::createFromFormat("Y-m-d",$date);
        if($d && $d->format("Y-m-d") == $date){
            return $d;
        } 
        return null;
    }
}