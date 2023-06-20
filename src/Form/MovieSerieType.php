<?php

namespace App\Form;

use App\Twig\AppExtension;
use App\Entity\Genre;
use App\Entity\MovieSerie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MovieSerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,[
                'label'         => 'Titre',
            ])

            ->add('description', TextareaType::class,[
                'label'         => 'Description',
        
            ])
            ->add('origine', ChoiceType::class,[
                'choices'  => [
                    'Française'  => 'Française',
                    'Américaine' => 'Américaine',
                ],
                'expanded'       => false,
                'multiple'       => false,
                ])
            ->add('imgAffiche', FileType::class, [
                'label'         => 'Image d\'affiche',
                'mapped'        => false,
                'required'      => false,
                'constraints'   => [
                    new File([
                        // 'maxSize'   => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Format non autorisé !',
                    ])
                ],
            ])
            ->add('imgHeader', FileType::class, [
                'label'         => 'Image header',
                'mapped'        => false,
                'required'      => false,
                'constraints'   => [
                    new File([
                        // 'maxSize'   => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Format non autorisé !',
                    ])
                ],
            ])
            ->add('realisateur', TextType::class)
            ->add('date_sortieAt', DateType::class, [
                'label'   => 'Date de sortie',
                'widget' => 'single_text',
                'html5' => true,
            ])
            ->add('acteur', TextType::class)
            ->add('nbSaison', NumberType::class, [
                'label'   => 'Nombre de saisons',
                'required' => false,
            ])
            ->add('plateforme', ChoiceType::class,[
                'choices'  => [

                    'Netflix'       => 'netflix',
                    'Disney+'       => 'disney+',
                    'Prime vidéo'   => 'prime_video',
                    'Youtube'       => 'youtube',

                ],
                'expanded'          => false,
                'multiple'          => false,
                ])
            ->add('bande_annonce', TextType::class)
            ->add('lien_redirection', TextType::class)
            ->add('duree',NumberType::class,[
                'label'   => 'Durée en minutes',
            ])
            ->add('type',  ChoiceType::class,[
                'choices'  => [
                    'Film'  => 'film',
                    'Série' => 'serie',
                ],
                'expanded'          => false,
                'multiple'          => false,
            ])
            // ->add('user')
            ->add('genres', EntityType::class, [
                
                'class'             => Genre::class,
                'choice_label'      => 'name',
                'expanded'          => true,
                'multiple'          => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MovieSerie::class,
        ]);
    }
}
