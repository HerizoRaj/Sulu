<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('raisonSociale', TextType::class, [
                'required' => false,
                'label' => 'Raison sociale',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Raison sociale'
                ]
            ])
            ->add('nom', TextType::class, [
                'required'=> true,
                'label'=>'Nom*',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Nom'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre nom'
                    ])
                ]
            ])
            ->add('prenom', TextType::class, [
                'required'=>true,
                'label'=>'Prénom*',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Prénom'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre prénom'
                    ])
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
                    new NotBlank([
                        'message' => 'Le code postal est obligatoire.',
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 5,
                        'exactMessage' => 'Le code postal doit comporter exactement {{ limit }} chiffres.',
                    ]),
                    new Regex([
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
                    new NotBlank([
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
                    new NotBlank([
                        'message' => 'Le numéro de téléphone est obligatoire.',
                    ]),
                    new Regex([
                        'pattern' => '/^0[1-9](\d{8})$/',
                        'message' => 'Le numéro de téléphone doit être valide et commencer par un 0 suivi de 9 chiffres.',
                    ]),
                    new Length([
                        'min' => 10,
                        'max' => 10,
                        'exactMessage' => 'Le numéro de téléphone doit comporter exactement {{ limit }} chiffres.',
                    ]),
                ],
            ])
            ->add('emailPrincipal', EmailType::class, [
                'required'=>true,
                'label'=>'E-mail principal*',
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
            ->add('password', PasswordType::class, [
                'label'=>'Mot de passe*',
                // instead of being set onto the object directly,
                'mapped' => false,
                // this is read and encoded in the controller
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Mot de passe'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('confirm_password', PasswordType::class, [
                'label' => 'Confirmation du mot de passe*',
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Confirmez votre mot de passe',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez confirmer votre mot de passe',
                    ]),
                ],
            ])
            ->add('recevoir', CheckboxType::class, [
                'label'=>'',
                'required'=>'false',
            ])
            ->add('civilite', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'Madame' => 'Madame',
                    'Monsieur' => 'Monsieur',
                ],
                'expanded' => true,  // Utilise des boutons radio au lieu d'une liste déroulante
                'multiple' => false, // Un seul choix possible
                'attr' => [
                    'class'=>'radio-group'
                ],
            ])
            ->add('region', TextType::class, [
                'label'=>'Region*',
                'required'=>true,
                'attr'=>[
                    'class' => 'form-control',
                    'placeholder' => 'Région',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez ajouter une région',
                    ]),
                ],
            ])
            ->add('siret', TextType::class, [
                'label' => 'Numéro SIRET',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le numéro SIRET est obligatoire.',
                    ]),
                    new Length([
                        'exactMessage' => 'Le numéro SIRET doit contenir exactement 14 chiffres.',
                        'min' => 14,
                        'max' => 14,
                    ]),
                    new Regex([
                        'pattern' => '/^\d{14}$/',
                        'message' => 'Le numéro SIRET doit contenir uniquement des chiffres.',
                    ]),
                ],
                'attr' => [
                    'class'=>'form-control',
                    'placeholder'=>'Siret'
                ],
            ])
            ->add('numTva', TextType::class, [
                'label' => 'Numéro de TVA',
                'required' => false, // Modifiez selon vos besoins
                'constraints' => [
                    new Regex([
                        'pattern' => '/^FR\d{11}$/', // Modifiez le pattern selon le format du numéro de TVA
                        'message' => 'Le numéro de TVA doit commencer par "FR" suivi de 11 chiffres.',
                    ]),
                ],
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Numéro de TVA'
                ]
            ])
            //->add('tvaApplicable', CheckboxType::class, [
            //    'label' => 'TVA Applicable',
            //    'required' => false,
            //    'attr'=>[
            //        'class'=>'form-control',
            //        'placeholder'=>'TVA Applicable'
            //    ]
            //])
            ->add('ribIban', TextType::class, [
                'label' => 'RIB / IBAN',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Le RIB/IBAN est obligatoire.']),
                    new Regex([
                        'pattern' => '/^FR\d{2}(?:\s?\d{4}){5}\s?\d{3}$/',
                        'message' => 'Le RIB/IBAN est invalide.',
                    ]),
                ],
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'RIB / IBAN'
                ]
            ])
            ->add('ribBic', TextType::class, [
                'label' => 'RIB / BIC',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Le BIC est obligatoire.']),
                    new Length([
                        'min' => 8,
                        'max' => 11,
                        'minMessage' => 'Le BIC doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le BIC ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Z0-9]{8,11}$/',
                        'message' => 'Le BIC doit être valide.',
                    ]),
                ],

                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'RIB / BIC'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
