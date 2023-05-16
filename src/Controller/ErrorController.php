<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController{
    public function start(){
        // return $this->render("inicio.html.twig");
        return $this->redirectToRoute('app_inicio_start');
    }
    
}