<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\TareaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DescargaController extends AbstractController
{
    #[Route("/tarea/descargar/{id}")]
    public function start(int $id, TareaRepository $tareaRepository)
    {
        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");
        $tarea = $tareaRepository->find($id);
        if(!$tarea){
            return $this->redirectToRoute('app_tareas_start');
        }

        $fichero = $tarea->getFile();

        if(!$fichero){
            return $this->redirectToRoute('app_tareas_start');
        }

        $rutaFichero = $this->getParameter("files_directory") . "/" . $fichero;

        $response = new Response();
        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $fichero);
        $response->headers->set("Content-Disposition", $disposition);
        $response->setContent(file_get_contents($rutaFichero));
        $this->addFlash("success", "Se a descargado correctamente");
        return $response;
    }
}
