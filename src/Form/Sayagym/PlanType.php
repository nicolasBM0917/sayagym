<?php

namespace App\Form\Sayagym;

use App\Entity\Sayagym\Plan;
use App\Entity\Sayagym\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rutina', TextType::class, [
                'label' => 'Rutina',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('enfoque', TextType::class, [
                'label' => 'Enfoque',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr' => array('class' => 'btn btn-success save-button')));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Plan::class,
        ]);
    }
}
