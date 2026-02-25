<?php

namespace App\Form;

use App\Entity\Donkey;
use App\Entity\Therapy;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminTherapyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            /* ── Campos base Service ── */
            ->add('basePrice', MoneyType::class, [
                'label'    => 'Precio base (€)',
                'currency' => 'EUR',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Descripción general',
            ])
            ->add('duration', TimeType::class, [
                'label'  => 'Duración',
                'widget' => 'choice',
                'hours'  => range(0, 8),
            ])
            ->add('maxAphor', IntegerType::class, [
                'label' => 'Aforo máximo',
            ])
            ->add('leenguage', ChoiceType::class, [
                'label'   => 'Idioma',
                'choices' => [
                    'Español' => 'es',
                    'Inglés'  => 'en',
                    'Francés' => 'fr',
                    'Alemán'  => 'de',
                ],
            ])
            ->add('donkey', EntityType::class, [
                'class'        => Donkey::class,
                'choice_label' => 'nombre',
                'label'        => 'Burro asignado',
                'required'     => false,
                'placeholder'  => 'Sin asignar',
            ])
            /* ── Campos específicos Therapy ── */
            ->add('place', TextType::class, [
                'label' => 'Lugar de la sesión',
            ])
            ->add('details', TextareaType::class, [
                'label'    => 'Detalles adicionales',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Therapy::class,
        ]);
    }
}
