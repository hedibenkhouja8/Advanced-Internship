<?php

namespace App\Form;

use App\Entity\Inventory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class InventoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Equipment')
            ->add('User')
            ->add('Locaation', ChoiceType::class, [
                'choices'  => [
                    'Administration office' => 'Administration office',
                    'IT department' => 'IT department',
                    'Management Department' => 'Management Department',
                ],
            ])
            ->add('Notes')
            ->add('OperatingSystem', ChoiceType::class, [
                'choices'  => [
                    'Windows' => 'Windows',
                    'Linux' => 'Linux',
                    'RedHat' => 'RedHat',
                    'SolidWorks' => 'SolidWorks',
                    'Other' => 'Other',
                ],
            ])
            ->add('State', ChoiceType::class, [
                'choices'  => [
                    'Perfect' => 'Perfect',
                    'Good' => 'Good',
                    'Average' => 'Average',
                    'Bad' => 'Bad',
                   
                ],
            ])
            ->add('Brand')
            ->add('Model')
            ->add('PurchaseDate')
            ->add('Supplier')
            ->add('LastScan')
            ->add('LastMaintenance')
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Inventory::class,
        ]);
    }
}
