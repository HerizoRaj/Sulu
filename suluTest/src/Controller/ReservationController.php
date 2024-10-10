<?php

declare(strict_types=1);

namespace App\Controller;

use Sulu\Bundle\WebsiteBundle\Controller\DefaultController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReservationController extends DefaultController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function index(): Response
    {
        return $this->render('reservation/index.html.twig');
    }

    #[Route('/reservations', name: 'app_reservations')]
    public function reservations(): Response
    {
        return $this->render('pages/reservation.html.twig');
    }

    #[Route('/reserver', name: 'app_reserver')]
    public function reserver(): Response
    {
        return $this->render('pages/reserver.html.twig');
    }
}
