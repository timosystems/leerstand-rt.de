<?php

namespace App\Form;

use App\Entity\Haus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewHausFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adresse', TextType::class, [
                'label'    => 'Straße und Nummer',
                'required' => true,
            ])
            ->add('ort', TextType::class, [
                'label'    => 'Ort',
                'required' => true,
            ])
            ->add('plz', TextType::class, [
                'label'    => 'Postleitzahl',
                'required' => true,
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Vollständig Leer' => 'Vollständig Leer',
                    'Teilweise Leer' => 'Teilweise Leer',
                    'Besetzt' => 'Besetzt',
                    'Abrissreif' => 'Abrissreif',
                ],
                'label'    => 'Status?',
            ])
            ->add('save', SubmitType::class, [
                'label'    => 'Haus eintragen',
                'attr' => ['class' => 'btn btn-primary'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Haus::class,
        ]);
    }
}
