<?php

namespace App\Form;

use App\Entity\Inventory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InventoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Equipment')
            ->add('User')
            ->add('Locaation')
            ->add('Notes')
            ->add('OperatingSystem')
            ->add('State')
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
