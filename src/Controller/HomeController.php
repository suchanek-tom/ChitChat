<?php

namespace App\Controller;

use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Token\Builder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {

        $token = (new Builder())
            ->withClaim()
        ;

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}