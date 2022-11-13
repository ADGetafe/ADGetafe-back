<?php

namespace App\Form;

use App\Entity\Noticias;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class NoticiasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('foto', FileType::class, [
                'label'=> 'Selecciona una imágen',
                'mapped' => false, 
                'required' => false
                ])

            ->add('titulo', TextType::class, [
                'attr' => [
                    'placeholder' => 'Escribe el titulo de tu Articulo Aqui',
                    'class'=> 'title'
                ]
            ])
            ->add('categoria', TextType::class, [
                'attr' => [
                    'placeholder' => 'Ej: Deporte, Alimentacion, Actividades, etc.',
                    'class'=> 'categoria'
                ]
            ])
            // ->add('createdAt')
            ->add('autor', TextType::class, [
                'attr' => [
                    'placeholder' => 'Escriba el nombre del autor/a',
                    'class' => 'autoria'
                ]
            ])
            ->add('articulo', CKEditorType::class, [
                'attr' => [
                    'placeholder' => 'Escriba su articulo',
                    'class' => 'articulo',
                    'block_prefix' => 'articulo_text',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Noticias::class,
        ]);
    }
}
