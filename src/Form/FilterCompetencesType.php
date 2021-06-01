<?php

namespace App\Form;

use App\Dto\filter;
use App\Entity\Competence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class FilterCompetencesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('filterCompetences', EntityType::class, [
                'class' => Competence::class,
                'choice_label' => 'competence_nom',
            ])
            ->add('Submit', SubmitType::class)
            
            // ->add('abonne')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => filter::class,
            "method"    => "GET",
        ]);
    }
}
