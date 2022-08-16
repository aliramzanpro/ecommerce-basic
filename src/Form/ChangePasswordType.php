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

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname',TextType::class,[
            'label' => 'Prénom',
            'disabled' => true,
            'attr' => [
            'placeholder' => 'Votre prénom'
            ]
        ])
        ->add('lastname',TextType::class,[   
            'label' => 'Prénom',
            'disabled' => true,
            'attr' => [
            'placeholder' => 'votre nom']
            ])

        ->add('email',EmailType::class, [
            'label' => 'Email',
            'disabled' => true,
            'attr' => [
            'placeholder' => 'votre Email']
        ])

        ->add('old_password',PasswordType::class, [  
            'mapped' => false,
            'label' => 'Mot de passe',
            'constraints' => new Length(['min'=>6, 'max'=>20]),
            'required'=> true,

            
        ])
        ->add('new_password',RepeatedType::class, [  
            'type' => PasswordType::class,
            'mapped' => false,
            'invalid_message' => "les mots de passes doivent etre identique.",
            'label' => 'Votre nouveau mot de passe',
            'constraints' => new Length(['min'=>6, 'max'=>20]),
            'required'=> true,

            'first_options' => [
                'label' => 'Nouveau mot de passe',
                'attr' => 
                [
                    'placeholder' => ' Votre Nouveau mot de passe']
                ],

            'second_options'=> [
                'label' => 'Confirmation du nouveau mot de passe',
                'attr'=> 
                [
                    'placeholder' => 'Confirmez votre nouveau mot de passe']
                ]
        ])

        ->add('submit',SubmitType::class,[
            'label' => "Mettre à jour r"
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
