<?php

namespace App\Form;

use App\Entity\EEmployee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EEmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('phoneNumber')
            ->add('email')
            ->add('adress')
            ->add('position')
            ->add('salary')
            ->add('birthDate')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EEmployee::class,
        ]);
    }
}
