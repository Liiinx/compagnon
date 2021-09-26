<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => ['class' => 'form-control-sm']
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'form-control-sm']
            ])
            ->add('category', EntityType::class, [
                'attr' => ['class' => 'form-control-sm'],
                'class' => Category::class,
                // uses the category.name property as the visible option string
                'choice_label' => 'name'
                // used to render a select box, check boxes or radios
//                 'multiple' => true,
//                 'expanded' => true,
            ])
            ->add('address', LocationType::class, [
                'label' => false
            ])
//            ->add('image')
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
