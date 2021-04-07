<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Location;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
            ->add('title', TextType::class)
            ->add('description', TextareaType::class)
            ->add('price', IntegerType::class)
            ->add('category', EntityType::class, [
                'class' => Category::class,
                // uses the category.name property as the visible option string
                'choice_label' => 'name'
                // used to render a select box, check boxes or radios
//                 'multiple' => true,
//                 'expanded' => true,
            ])
//            ->add('user')
            ->add('address', TextType::class)
            /*->add('address', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'address'
            ])*/
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
