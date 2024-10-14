<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class ClientController extends AbstractController
{
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ){
        $this->entityManager = $entityManager;
    }

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
        ClientRepository $clientRepository,
    ): Response
    {
        $client = new Client();
        $inscriptionForm = $this->createForm(ClientType::class, $client);
        $inscriptionForm->handleRequest($request);

        //$token = $request->query->get('token');

        if ($inscriptionForm->isSubmitted() && $inscriptionForm->isValid()){
            // Récupération des mots de passe
            $password = $inscriptionForm->get('password')->getData();
            $email = $inscriptionForm->get('emailPrincipal')->getData();
            $emailF = $inscriptionForm->get('emailFacturation')->getData();
            // Vérification des adresses e-mail s'ils existent déjà
            $existEmailPrincipal = $clientRepository->findOneBy(['emailPrincipal' => $email]);
            $existEmailFacturation = $clientRepository->findOneBy(['emailFacturation' => $emailF]);
            $error = false;
            if ($existEmailPrincipal) {
                $error = true;
                $inscriptionForm->get('emailPrincipal')->addError(new FormError("Cette adresse e-mail existe déjà!"));
            }
            if ($existEmailFacturation){
                $error = true;
                $inscriptionForm->get('emailFacturation')->addError(new FormError("Cette adresse e-mail existe déjà!"));
            }

            if ($error){
                return $this->render('pages/inscription.html.twig', [
                    'inscriptionForm'=>$inscriptionForm,
                ]);
            }

            $client->setCivilite($inscriptionForm->get('civilite')->getData());
            $client->setNom($inscriptionForm->get('nom')->getData());
            $client->setPrenom($inscriptionForm->get('prenom')->getData());
            $client->setEmailPrincipal($email);
            $client->setEmailFacturation($emailF);
            $client->setPassword($userPasswordHasher->hashPassword($client, $password));
            $client->setAdresse($inscriptionForm->get('adresse')->getData());
            $client->setTel($inscriptionForm->get('tel')->getData());
            $client->setVille($inscriptionForm->get('ville')->getData());
            $client->setCodePostal($inscriptionForm->get('codePostal')->getData());
            $client->setPays($inscriptionForm->get('pays')->getData());
            $client->setRaisonSociale($inscriptionForm->get('raisonSociale')->getData());
            $client->setRecevoir($inscriptionForm->get('recevoir')->getData());
            $client->setSiret($inscriptionForm->get('siret')->getData());
            $client->setNumTva($inscriptionForm->get('numTva')->getData());
            //$client->setTvaApplicable($inscriptionForm->get('tvaApplicable')->getData());
            $client->setRibIban($inscriptionForm->get('ribIban')->getData());
            $client->setRibBic($inscriptionForm->get('ribBic')->getData());

            $this->entityManager->persist($client);
            $this->entityManager->flush();

            //redirection espace client
            return $this->redirectToRoute('app_client', [
                'client' => $client->getId(),
            ]);
        }
        return $this->render('pages/inscription.html.twig', [
            'inscriptionForm'=>$inscriptionForm,
        ]);
    }

    #[Route('/client', name: 'app_client')]
    public function index(): Response
    {
        return $this->render('pages/client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
}
