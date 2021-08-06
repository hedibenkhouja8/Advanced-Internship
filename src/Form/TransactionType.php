<?php

namespace App\Form;

use App\Entity\Transaction;
use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Input' => 'Input',
                    'Output' => 'Output',
                ],
            ])
            ->add('note')
            ->add('quantity')
            ->add('TransactionDate', DateType::class, [
                'widget' => 'choice',
            ])
           
            ->add('product', EntityType::class, [
                // looks for choices from this entity
                'class' => Product::class,
            
                // uses the User.username property as the visible option string
                'choice_label' => 'reference',
            
                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}
