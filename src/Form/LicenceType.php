<?php

namespace App\Form;

use App\Entity\Licence;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class LicenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Product_name')
            ->add('Supplier')
            
            ->add('Compilance_type', ChoiceType::class, [
                'choices'  => [
                    'Pro' => 'Pro',
                    'Normal' => 'Normal',
                  
                ],
            ])
            ->add('User')
            ->add('expiration_date', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('category', EntityType::class, [
                // looks for choices from this entity
                'class' => Category::class,
            
                // uses the User.username property as the visible option string
                'choice_label' => 'Name',
            
                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ])
            
            ->add('Purchase_date', DateType::class, [
                'widget' => 'single_text',
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Licence::class,
        ]);
    }
}
