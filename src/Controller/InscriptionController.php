<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    #[Route('/inscription/{id}', name: 'app_inscription', requirements: ['id' => '\d+'], defaults: ['id' => 1])]
    public function index(): Response
    {
        
}
