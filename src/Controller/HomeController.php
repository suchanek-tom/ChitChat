<?php

namespace App\Controller;

use Firebase\JWT\Key;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Token\Builder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $username = $this->getUser()->getUsername();
        $token = (new Builder())
            ->withClaim('mercure', ['subscribe' => [sprintf("/%s", $username)]])
            ->getToken(
                new Sha256(),
                new Key($this->getParameter('mercure_secret_key'))
            )
        ;

        $response = $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);

        $response->headers->setCookie(
            new Cookie(
                'mercureAuthorization',
                $token,
                (new \DateTime())
                ->add(new \DateInterval('PT2H')),
                '/.well-known/mercure',
                null,
                false,
                true,
                false,
                'strict'
            )
        );

        return $response;
    }
}