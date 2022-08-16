<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname',TextType::class,[
            'label' => 'Prénom',
            'constraints' => new Length(['min'=>2, 'max'=>20]),
            'attr' => [
            'placeholder' => 'Merci de renseigner votre nom'
            ]
        ])
        ->add('lastname',TextType::class,[   
            'label' => 'Prénom',
            'constraints' => new Length(['min'=>2, 'max'=>20]),
            'attr' => [
            'placeholder' => 'Merci de renseigner votre nom']
            ])

        ->add('email',EmailType::class, [
            'label' => 'Email',
            'constraints' => new Length(['min'=>2, 'max'=>60]),
            'attr' => [
            'placeholder' => 'Merci de renseigner votre Email']
        ])

        ->add('password',RepeatedType::class, [  
            'type' => PasswordType::class,
            'invalid_message' => "les mots de passes doivent etre identique.",
            'label' => 'Mot de passe',
            'constraints' => new Length(['min'=>6, 'max'=>20]),
            'required'=> true,

            'first_options' => [
                'label' => 'Mot de passe',
                'attr' => 
                [
                    'placeholder' => 'Mot de passe']
                ],

            'second_options'=> [
                'label' => 'Confirmation de Mot de passe',
                'attr'=> 
                [
                    'placeholder' => 'Confirmation mot de passe']
                ]
        ])


        

        ->add('submit',SubmitType::class,[
            'label' => "S'inscrire"
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
