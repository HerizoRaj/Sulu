<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Facture;
use App\Repository\ClientRepository;
use App\Repository\FactureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\PdfGenerator;

class FactureController extends AbstractController
{
    private PdfGenerator $pdfGenerator;

    public function __construct(PdfGenerator $pdfGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
    }

    #[Route('/facture/{id}', name: 'app_facture')]
    public function generateFacture(Facture $facture, FactureRepository $factureRepository, ClientRepository $clientRepository): Response
    {
        $facture = $factureRepository->find($facture->getId());

        if (!$facture) {
            throw $this->createNotFoundException('Facture non trouvée');
        }
        // Récupère directement le client de la facture
        $client = $facture->getClient();

        // Génère le PDF
        $pdfContent = $this->pdfGenerator->generateInvoicePdf($facture, $client);

        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="facture_'.$facture->getId().'.pdf"',
        ]);
    }
}
