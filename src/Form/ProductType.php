<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference')
            ->add('description')
            ->add('manufacturer')
            ->add('quantity')
            ->add('stocking_area', ChoiceType::class, [
                'choices'  => [
                    'Main Warehouse' => 'Main Warehouse',
                    'Backyard Warehouse' => 'Backyard Warehouse',
                    'IT department Warehouse' => 'IT department Warehouse',
                    'Mechanics Department Warehouse' => 'Mechanics Department Warehouse',
                ],
            ])
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
