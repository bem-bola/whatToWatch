<?php

namespace App\Form;

use App\Entity\Search;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titles', null, [
                'attr' => [
                    'placeholder' => 'Rechercher un film/série',
                ],
                'row_attr' => [
                    'class' => 'text-editor',
                    'placeholder' => 'Rechercher un film/série'
                    ]])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
        ]);
    }
}
