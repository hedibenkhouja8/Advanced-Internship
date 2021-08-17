<?php

namespace App\Form;

use App\Entity\PropertySearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('manufacturer', ChoiceType::class, [
                'choices'  => [
                    ''=>'',
                    'Mechanic Depatrtment' => 'Mechanic Depatrtment',
                    'Chemics Department' => 'Chemics Department',
                    'IT department' => 'IT department ',
                ],
                'required'=> false,
            ])
            ->add('stockingarea', ChoiceType::class, [
                'choices'  => [
                    ''=>'',
                    'Main Warehouse' => 'Main Warehouse',
                    'Backyard Warehouse' => 'Backyard Warehouse',
                    'IT department Warehouse' => 'IT department Warehouse',
                    'Mechanics Department Warehouse' => 'Mechanics Department Warehouse',
                ],
                
                'label'=> 'Stocking Area',
                'required'=> false,
            ])
            ->add('minQuantity',IntegerType::class,[
                'required'=> false,
                'label'=> 'Minimum Quantity',
                'attr' =>['Placeholder'=>'Minimum Quantity']

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }


    public function getPrefix(){

        return '';
    }
}
