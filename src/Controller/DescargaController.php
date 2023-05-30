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

        /**
         * @Alejandro
         * 
         * Modifica la respuesta del servidor para indicar al navegador que actue como una descarga mira la cabecera para saber como actuar y despues hace la descarga del contenido
         */
        $response = new Response();
        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $fichero);
        $response->headers->set("Content-Disposition", $disposition);
        $response->setContent(file_get_contents($rutaFichero));
        $this->addFlash("success", "Se a descargado correctamente");
        return $response;
    }
}
