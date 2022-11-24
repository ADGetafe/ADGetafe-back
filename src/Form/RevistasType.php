<?php

namespace App\Form;

use App\Entity\Revistas;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class RevistasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo', TextType::class, [
                'attr' => [
                    'placeholder' => 'Escribe el titulo de la revista Aqui',
                    'class'=> 'title'
                    ]
                ])
            ->add('revista', FileType::class, [
                'label'=> 'Selecciona una revista',
                'mapped' => false, 
                'required' => false
                ])

                ->add('fragmento', TextareaType::class, [
                    'attr' => [
                        'placeholder' => 'Escriba una descripción para la revista',
                        'class' => 'revista',
                        'block_prefix' => 'revista_text',
                    ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Revistas::class,
        ]);
    }
}
