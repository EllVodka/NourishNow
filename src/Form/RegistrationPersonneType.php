<?php

namespace App\Form;

use App\Entity\Personne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationPersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('telephone')
            ->add('role',ChoiceType::class,[
                "label"=>"M'inscrire en tant que :",
                "required"=> false,
                'mapped' => false,
                'choices'=>[
                    "Client"=>"Client",
                    "Livreur"=>"Livreur",
                    "Restaurateur"=>"Restaurateur",
                ],
            ])
            ->add('adresse')
            ->add('vehicule')
            ->add('Ajouter', SubmitType::class,[
                "label"=>"S'inscrire",
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
