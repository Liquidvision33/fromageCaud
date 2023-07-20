<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Prenom', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le prénom est requis.'])
                ],
                'attr' => [
                    'placeholder' => 'Prenom',
                    'class' => 'form-control col-6 mb-3'
                ],
            ])
            ->add('Nom', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le nom est requis.'])
                ],
                'attr' => [
                    'placeholder' => 'Nom',
                    'class' => 'form-control col-6 mb-3'
                ],
            ])
            ->add('Email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control col-6 mb-3',
                    'placeholder' => 'Veuillez entrer votre E-mail',
                ],
                'label' => 'E-mail',
                'constraints' => [
                    new NotBlank(['message' => 'L\'adresse e-mail est requise.']),
                    new Email(['message' => 'L\'adresse e-mail n\'est pas valide.']),
                ],
            ])
            ->add('Sujet', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez indiquer votre sujet'])
                ],
                'attr' => [

                    'placeholder' => 'Sujet',
                    'class' => 'form-control col-6 mb-3'
                ],
            ])
            ->add('Contenu', TextareaType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez rédiger un message'])
                ],
                'attr' => [
                    'placeholder' => 'Votre message',
                    'class' => 'form-control col-6 mb-3'
                ],
            ])
            ->add('Envoyer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-2 mb-5',
                    'type' => 'submit',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
