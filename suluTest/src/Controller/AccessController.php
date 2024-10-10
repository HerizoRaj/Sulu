<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccessController extends AbstractController
{
    #[Route('/access', name: 'app_access')]
    public function index(Request $request): Response
    {
        // Tableau des utilisateurs autorisés et leurs périodes d'accès
        $users = [
            'user1' => [
                'password' => 'password1',
                'access_time_start' => '09:00',
                'access_time_end' => '20:00',
            ],
            'user2' => [
                'password' => 'password2',
                'access_time_start' => '08:00',
                'access_time_end' => '17:00',
            ]
        ];

        // Récupération des paramètres GET
        $login = $request->query->get('login');
        $password = $request->query->get('password');

        // Vérification si le login existe et si le mot de passe est correct
        if (isset($users[$login]) && $users[$login]['password'] === $password) {
            // Récupération de l'heure actuelle
            $current_time = (new \DateTime())->format('H:i');

            // Vérification si l'heure actuelle est dans la plage autorisée
            if ($current_time >= $users[$login]['access_time_start'] && $current_time <= $users[$login]['access_time_end']) {
                // Si les informations sont correctes et dans la bonne période, retourne l'URL encodée en base64
                return new Response("connecte-" . base64_encode("http://coworking.arobases.fr:1665/control?cmd=pulse,12,0,300"));
            }
        }

        // Si échec, retourner une réponse vide
        return new Response('');
    }
}
