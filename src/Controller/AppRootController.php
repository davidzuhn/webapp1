<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppRootController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    #[Route('/', stateless:true)]
    public function homepage(): Response
    {
        return $this->render('root/index.html.twig', [
        ]);
    }
}