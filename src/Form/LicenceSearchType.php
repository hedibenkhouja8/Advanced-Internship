<?php

namespace App\Form;

use app\Entity\LicenceSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class LicenceSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', TextType::class, array('required' => false))
            ->add('compilancetype', ChoiceType::class, [
                'choices'  => [
                    ''=>'',
                    'Pro' => 'Pro',
                    'Normal' => 'Normal',
                  
                ],'required'=> false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LicenceSearch::class,
        ]);
    }
}
