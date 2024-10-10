<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use Sulu\Bundle\HttpCacheBundle\Cache\SuluHttpCache;
use Sulu\Bundle\WebsiteBundle\Resolver\TemplateAttributeResolverInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

class ClientController extends AbstractController
{
    #[Route('/login', name: 'app_login_client')]
    public function login(): Response
    {
        return $this->render('pages/login.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/inscription', name: 'app_inscription_client')]
    public function inscription(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        TemplateAttributeResolverInterface $resolver,
        Environment $twig
    ): Response
    {
        $client = new Client();
        $inscriptionForm = $this->createForm(ClientType::class, $client);
        $inscriptionForm->handleRequest($request);
        if ($inscriptionForm->isSubmitted() && $inscriptionForm->isValid()){
            echo "ok";
        }
        return $this->render('pages/inscription.html.twig', [
            'inscriptionForm'=>$inscriptionForm
        ]);
    }

    #[Route('/client', name: 'app_client')]
    public function index(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
}
