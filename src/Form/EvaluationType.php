<?php

namespace App\Form;

use App\Entity\Evaluation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvaluationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('note', ChoiceType::class, [
                "label" => "la note:",
                "required" => true,
                'choices' => [
                    "Très mauvais" => 1,
                    "Mauvais" => 2,
                    "Bon" => 3,
                    "Très bon" => 4,
                    "Parfait" => 5,
                ],
            ])
            ->add('Ajouter', SubmitType::class, [
                "label" => "Continuer",
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evaluation::class,
        ]);
    }
}
