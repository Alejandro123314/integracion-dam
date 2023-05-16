<?php
namespace App\Controller;

use App\Repository\TareaRepository;
use App\Entity\Tarea;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CrearTareaController extends AbstractController{
    #[Route("/tareas/crear/{titulo}")]
    public function start(string $titulo ,TareaRepository $tareaRepository){
        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");
        $usuario = $this->getUser();
        $tarea = new Tarea();
        $tarea->setTitulo($titulo);
        $tarea->setPrioridad("baja");
        $tarea->setDescripcion("");
        $tarea->setFechaCreacion(new DateTime());
        $tarea->addUsuario($usuario);

        $tarea->setCompletada(false);
        $tareaRepository->save($tarea, true);
        return $this->redirectToRoute('app_tareas_start');
    }
}