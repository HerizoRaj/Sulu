<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Client;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class LoginController extends AbstractController
{
    private $csrfTokenGenerator;
    private $csrfTokenStorage;

    public function __construct(TokenGeneratorInterface $csrfTokenGenerator, TokenStorageInterface $csrfTokenStorage)
    {
        $this->csrfTokenGenerator = $csrfTokenGenerator;
        $this->csrfTokenStorage = $csrfTokenStorage;
    }

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('pages/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
}
