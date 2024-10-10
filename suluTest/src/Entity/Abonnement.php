<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AbonnementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbonnementRepository::class)]
class Abonnement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'integer')]
    private ?int $ticketsDemiJournees = null;

    #[ORM\Column(type: 'integer')]
    private ?int $ticketsJournees = null;

    #[ORM\Column(type: 'integer')]
    private ?int $ticketsMois = null;

    #[ORM\Column(type: 'integer')]
    private ?int $ticketsHeuresSDR = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?float $montant = null;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'abonnements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTicketsDemiJournees(): ?int
    {
        return $this->ticketsDemiJournees;
    }

    public function setTicketsDemiJournees(int $ticketsDemiJournees): self
    {
        $this->ticketsDemiJournees = $ticketsDemiJournees;
        return $this;
    }

    public function getTicketsJournees(): ?int
    {
        return $this->ticketsJournees;
    }

    public function setTicketsJournees(int $ticketsJournees): self
    {
        $this->ticketsJournees = $ticketsJournees;
        return $this;
    }

    public function getTicketsMois(): ?int
    {
        return $this->ticketsMois;
    }

    public function setTicketsMois(int $ticketsMois): self
    {
        $this->ticketsMois = $ticketsMois;
        return $this;
    }

    public function getTicketsHeuresSDR(): ?int
    {
        return $this->ticketsHeuresSDR;
    }

    public function setTicketsHeuresSDR(int $ticketsHeuresSDR): self
    {
        $this->ticketsHeuresSDR = $ticketsHeuresSDR;
        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;
        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;
        return $this;
    }
}
