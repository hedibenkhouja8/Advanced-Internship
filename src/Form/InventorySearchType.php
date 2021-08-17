<?php

namespace App\Form;

use App\Entity\InventorySearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class InventorySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('location', ChoiceType::class, [
                'choices'  => [
                    ''=>'',
                    'Administration office' => 'Administration office',
                    'IT department' => 'IT department',
                    'Management Department' => 'Management Department',
                    'Warehouse' => 'Warehouse',
                ],
                'required'=> false,
              
            ])
            ->add('operatingsystem', ChoiceType::class, [
                'choices'  => [
                    ''=>'',
                    'Windows' => 'Windows',
                    'Linux' => 'Linux',
                    'RedHat' => 'RedHat',
                    'SolidWorks' => 'SolidWorks',
                    'Other' => 'Other',
                ],
                'required' => false,
            ])
            ->add('state', ChoiceType::class, [
                'choices'  => [
                    ''=>'',
                    'Perfect' => 'Perfect',
                    'Good' => 'Good',
                    'Average' => 'Average',
                    'Bad' => 'Bad',
                   
                ],
                'required' => false,
            ])
            ->add('brand', TextType::class, array('required' => false))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InventorySearch::class,
        ]);
    }
}
