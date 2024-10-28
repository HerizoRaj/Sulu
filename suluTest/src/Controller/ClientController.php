<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use App\Repository\FactureRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('client')]
class ClientController extends AbstractController
{
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ){
        $this->entityManager = $entityManager;
    }

    #[Route('/inscription', name: 'app_inscription_client')]
    public function inscription(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        ClientRepository $clientRepository,
        UserRepository $userRepository
    ): Response
    {
        $client = new Client();
        $user = new User();
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
            return $this->redirectToRoute('app_espace_client', [
                //'client' => $client->getId(),
            ]);
        }
        return $this->render('pages/inscription.html.twig', [
            'inscriptionForm'=>$inscriptionForm,
        ]);
    }

    #[Route('/espace-client', name: 'app_espace_client')]
    public function index(): Response
    {
        return $this->render('pages/client/client_home.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/ouvrir', name: 'app_client_unlock_door')]
    public function unlock_door(): Response
    {
        return $this->render('pages/client/client_home.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/profil', name: 'app_client_profile')]
    public function profile(): Response
    {
        // Récupère le client connecté
        /** @var Client $client */
        //$client = $this->getUser();
        $clientRepository = $this->entityManager->getRepository(client::class);
        $client = $clientRepository->findOneBy([]);

        return $this->render('pages/client/client_profile.html.twig', [
            'client' => $client,
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/profil/modifier', name: 'app_client_edit_profil')]
    public function editProfile(Request $request): Response
    {
        // Récupère le client connecté
        /** @var Client $client */
        //$client = $this->getUser();

        $clientRepository = $this->entityManager->getRepository(client::class);
        $user = $clientRepository->findOneBy([]);

        // Création du formulaire
        $form = $this->createForm(ClientType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer les modifications
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            // Message de succès et redirection
            $this->addFlash('success', 'Profil mis à jour avec succès.');

            return $this->redirectToRoute('client_profile');
        }

        return $this->render('pages/client/edit_profile.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    #[Route('/achat', name: 'app_client_achat_credit')]
    public function achat(): Response
    {
        return $this->render('pages/client/client_profile.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/reserver', name: 'app_client_reserver')]
    public function reserver(): Response
    {
        return $this->render('pages/client/client_book_meeting_room.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/mes-factures', name: 'app_client_facture')]
    public function facture(FactureRepository $factureRepository): Response
    {
        // Obtenez l'utilisateur connecté
        #$client = $this->getUser();

        // Vérifiez que l'utilisateur est un client et est bien connecté
        #if (!$client) {
        #    throw $this->createAccessDeniedException('Vous devez être connecté pour voir vos factures.');
        #}

        // Récupérez les factures pour le client
        $factures = $factureRepository->findall();
        #$factures = $factureRepository->findBy(['client' => $client]);

        // Retournez la vue avec la liste des factures
        return $this->render('pages/client/client_facture.html.twig', [
            'factures' => $factures,
        ]);
    }


}
