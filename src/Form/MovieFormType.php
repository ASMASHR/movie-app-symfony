<?php

namespace App\Form;

use App\Entity\Actor;
use App\Entity\Category;
use App\Entity\Movie;
use Doctrine\DBAL\Types\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType as TypeDateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class, [
                'attr'=>array(
                    'class'=>'bg-transparent block  mt-10 border-b-2 w-full h-20 text-3xl outline-none',
                    'placeholder'=>'Enter  the title ',
                    
                ),
                'label'=>false,
                'required'=>false,
            ])
            ->add('category',EntityType::class,[
                'attr'=>array(
                'class'=>'bg-transparent mt-10 block border-b-2 w-full h-50 text-3xl outline-none',
                
            ),
                'class'=>Category::class,
                'choice_label'=>'title',
                'multiple' => false,
                'label'=>false
            ])
            ->add('releaseYear', IntegerType::class, [
                'attr'=>array(
                    'class'=>'bg-transparent mt-10 block border-b-2 w-full h-20 text-3xl outline-none',
                    'placeholder'=>'Enter  the film\'s release year ',
                    
                ),
                'required'=>false,
                'label'=>false
            ])
            ->add('description',TextareaType::class, [
                'attr'=>array(
                    'class'=>'bg-transparent mt-10 block border-b-2 w-full h-50 text-3xl outline-none',
                    'placeholder'=>'Enter  the film\'s description ',
                    
                ),
                'required'=>false,
                'label'=>false
            ])
            ->add('imagePath',FileType::class, [
                'attr'=>array(
                    'class'=>'bg-transparent mt-10 block border-b-2 w-full h-20 text-3xl outline-none',

                    
                ),
                'required'=>false,
                'mapped'=>false,
                'label'=>false] )
            ->add('actors',EntityType::class,[
                'attr'=>array(
                'class'=>'bg-transparent mt-10 block border-b-2 w-full h-50 text-3xl outline-none',
                
            ),
                'class'=>Actor::class,
                'choice_label'=>'name',
                'multiple' => true,
                'label'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
