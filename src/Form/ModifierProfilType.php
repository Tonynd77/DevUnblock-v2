<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Competence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ModifierProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('abonne_email', TextType::class, [
                'label' => 'Email'
            ])
            // ->add('roles')
            // ->add('password')
            ->add('abonne_nom', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('abonne_prenom', TextType::class, [
                'label' => 'Prenom'
            ])
            ->add('abonne_image', TextType::class, [
                'label' => "Image"
            ])
            ->add('abonne_tel', TextType::class, [
                'label' => 'Tel'
            ])
            ->add('abonne_region', TextType::class, [
                'label' => 'Region'
            ])
            ->add('abonne_description', TextType::class, [
                'label' => 'Description'
            ])
            ->add('abonne_username', TextType::class, [
                'label' => 'Pseudo'
            ])
            ->add('competences', EntityType::class, [
                'class' => Competence::class,
                'choice_label' => 'competence_nom',
                'multiple' => true,
                'label' => 'Vos compétences'
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
