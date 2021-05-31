<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Competence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('abonne_email', TextType::class, [
                'label' => 'Email*'
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de Passe*'
            ])
            ->add('confirm_password', PasswordType::class)
            ->add('abonne_nom', TextType::class, [
                'label' => 'Nom*'
            ])
            ->add('abonne_prenom', TextType::class, [
                'label' => 'Prenom*'
            ])
            ->add('abonne_image')
            ->add('abonne_tel', TextType::class, [
                'label' => 'Numero de tel',
                'required'=>false
            ])
            ->add('abonne_region', TextType::class, [
                'label' => 'Région',
                'required'=>false
            ])
            ->add('abonne_description', TextType::class, [
                'label' => 'Description',
                'required'=>false
            ])
            ->add('abonne_username', TextType::class, [
                'label' => 'Pseudo*'
            ])
            ->add('competences', EntityType::class, [
                'class' => Competence::class,
                'choice_label' => 'competence_nom',
                'multiple' => true,
                'label' => 'Vos compétences* (Choissisez une ou plusieurs compétences)'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Inscription'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}