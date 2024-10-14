<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client implements PasswordAuthenticatedUserInterface
{
    public function __construct()
    {
        $this->token = bin2hex(random_bytes(32));
        $this->notifications = new ArrayCollection();
        $this->dateInscription = new \DateTime();
    }
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @Assert\NotBlank(message="Le numéro SIRET est obligatoire.")
     * @Assert\Length(
     *      exactMessage = "Le numéro SIRET doit contenir exactement 14 chiffres.",
     *      min = 14,
     *      max = 14
     * )
     * @Assert\Regex(
     *     pattern="/^\d{14}$/",
     *     message="Le numéro SIRET doit contenir uniquement des chiffres."
     * )
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $siret = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numTva = null;

    #[ORM\Column(nullable: true)]
    private ?float $tvaApplicable = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $raisonSociale = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 50)]
    private ?string $codePostal = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(length: 255)]
    private ?string $pays = null;

    #[ORM\Column(length: 50)]
    private ?string $tel = null;

    #[ORM\Column(length: 255)]
    private ?string $emailPrincipal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $emailFacturation = null;

    #[ORM\Column(length: 255)]
    private ?string $ribIban = null;

    #[ORM\Column(length: 255)]
    private ?string $ribBic = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateInscription = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse2 = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private ?bool $recevoir = null;

    #[ORM\Column(length: 50)]
    private ?string $civilite = null;

    #[ORM\Column(length: 255)]
    private ?string $region = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): static
    {
        $this->siret = $siret;

        return $this;
    }

    public function getNumTva(): ?string
    {
        return $this->numTva;
    }

    public function setNumTva(?string $numTva): static
    {
        $this->numTva = $numTva;

        return $this;
    }

    public function getTvaApplicable(): ?float
    {
        return $this->tvaApplicable;
    }

    public function setTvaApplicable(?float $tvaApplicable): static
    {
        $this->tvaApplicable = $tvaApplicable;

        return $this;
    }

    public function getRaisonSociale(): ?string
    {
        return $this->raisonSociale;
    }

    public function setRaisonSociale(?string $raisonSociale): static
    {
        $this->raisonSociale = $raisonSociale;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): static
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): static
    {
        $this->pays = $pays;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    public function getEmailPrincipal(): ?string
    {
        return $this->emailPrincipal;
    }

    public function setEmailPrincipal(string $emailPrincipal): static
    {
        $this->emailPrincipal = $emailPrincipal;

        return $this;
    }

    public function getEmailFacturation(): ?string
    {
        return $this->emailFacturation;
    }

    public function setEmailFacturation(?string $emailFacturation): static
    {
        $this->emailFacturation = $emailFacturation;

        return $this;
    }

    public function getRibIban(): ?string
    {
        return $this->ribIban;
    }

    public function setRibIban(string $ribIban): static
    {
        $this->ribIban = $ribIban;

        return $this;
    }

    public function getRibBic(): ?string
    {
        return $this->ribBic;
    }

    public function setRibBic(string $ribBic): static
    {
        $this->ribBic = $ribBic;

        return $this;
    }

    public function getDateInscription(): \DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): self
    {
        $this->dateInscription = $dateInscription;
        return $this;
    }

    public function getAdresse2(): ?string
    {
        return $this->adresse2;
    }

    public function setAdresse2(?string $adresse2): static
    {
        $this->adresse2 = $adresse2;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function isRecevoir(): ?bool
    {
        return $this->recevoir;
    }

    public function setRecevoir(?bool $recevoir): static
    {
        $this->recevoir = $recevoir;
        return $this;
    }

    public function getCivilite(): ?string
    {
        return $this->civilite;
    }

    public function setCivilite(string $civilite): static
    {
        $this->civilite = $civilite;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): static
    {
        $this->region = $region;

        return $this;
    }
}
