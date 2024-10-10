<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('siret')
            ->add('numTva')
            ->add('tvaApplicable')
            ->add('raisonSociale', TextType::class, [
                'required' => false,
                'label' => 'Raison sociale',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Raison sociale'
                ],
                'constraints' => [
                    new Assert\Length([
                        'min' => 2,
                        'max' => 255,
                        'minMessage' => 'La raison sociale doit comporter au moins {{ limit }} caractères.',
                        'maxMessage' => 'La raison sociale ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ],
            ])
            ->add('nom', TextType::class, [
                'required'=> true,
                'label'=>'Nom*',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Nom'
                ]
            ])
            ->add('prenom', TextType::class, [
                'required'=>true,
                'label'=>'Prénom*',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Prénom'
                ]
            ])
            ->add('adresse', TextType::class, [
                'required'=>true,
                'label'=>'Adresse*',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Adresse'
                ]
            ])
            ->add('codePostal', TextType::class, [
                'required' => true,
                'label' => 'Code postal*',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Code postal'
                ],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le code postal est obligatoire.',
                    ]),
                    new Assert\Length([
                        'min' => 5,
                        'max' => 5,
                        'exactMessage' => 'Le code postal doit comporter exactement {{ limit }} chiffres.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^\d{5}$/',
                        'message' => 'Le code postal doit comporter 5 chiffres.',
                    ]),
                ],
            ])
            ->add('ville', TextType::class, [
                'required'=>true,
                'label'=>'Ville*',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Ville'
                ]
            ])
            ->add('pays', ChoiceType::class, [
                'required' => true,
                'label' => 'Pays*',
                'placeholder' => 'Choisissez un pays',
                'choices' => [
                    'France' => 'FR',
                    'Belgique' => 'BE',
                    'Suisse' => 'CH',
                    'Canada' => 'CA',
                    'États-Unis' => 'US',
                    // Ajoute d'autres pays si nécessaire
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le choix du pays est obligatoire.',
                    ]),
                ],
            ])
            ->add('tel', TelType::class, [
                'required' => true,
                'label' => 'Téléphone mobile*',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Téléphone mobile'
                ],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le numéro de téléphone est obligatoire.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^0[1-9](\d{8})$/',
                        'message' => 'Le numéro de téléphone doit être valide et commencer par un 0 suivi de 9 chiffres.',
                    ]),
                    new Assert\Length([
                        'min' => 10,
                        'max' => 10,
                        'exactMessage' => 'Le numéro de téléphone doit comporter exactement {{ limit }} chiffres.',
                    ]),
                ],
            ])
            ->add('emailPrincipal', EmailType::class, [
                'required'=>true,
                'label'=>'E-mail principal',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'E-mail principal'
                ],
                'constraints' => [
                    new Email([
                        'message' => 'Veuillez entrer une adresse email valide',
                        'mode' => Email::VALIDATION_MODE_HTML5_ALLOW_NO_TLD
                    ]),
                ]
            ])
            ->add('emailFacturation', EmailType::class, [
                'required'=>false,
                'label'=>'E-mail de facturation',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'E-mail de facturation'
                ],
                'constraints' => [
                    new Email([
                        'message' => 'Veuillez entrer une adresse email valide',
                        'mode' => Email::VALIDATION_MODE_HTML5_ALLOW_NO_TLD
                    ]),
                ]
            ])
            ->add('ribIban')
            ->add('ribBic')
            ->add('dateInscription', null, [
                'widget' => 'single_text',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
