<?php

namespace App\Form;

use App\Entity\Group;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('register', TextType::class, array(
                'attr' => array(
                    'autofocus' => false,
                    'class' => 'form-control',
                    'placeholder' => 'register',
                ),
                'trim' => true,
                'required' => true,
            ))
            ->add('lastName', TextType::class, array(
                'attr' => array(
                    'autofocus' => false,
                    'class' => 'form-control',
                    'placeholder' => 'lastName',
                ),
                'trim' => true,
                'required' => true,
            ))
            ->add('firstName', TextType::class, array(
                'attr' => array(
                    'autofocus' => false,
                    'class' => 'form-control',
                    'placeholder' => 'firstName',
                ),
                'trim' => true,
                'required' => true,
            ))
            ->add('file', TextType::class, array(
                'attr' => array(
                    'autofocus' => false,
                    'class' => 'form-control',
                    'placeholder' => 'file',
                ),
                'trim' => true,
                'required' => true,
            ))
            ->add('email', TextType::class, array(
                'attr' => array(
                    'autofocus' => false,
                    'class' => 'form-control',
                    'placeholder' => 'email',
                ),
                'trim' => true,
                'required' => true,
            ))
            ->add('phone', NumberType::class, array(
                'attr' => array(
                    'autofocus' => false,
                    'class' => 'form-control',
                    'placeholder' => 'phone',
                ),
                'trim' => true,
                'required' => true,
            ))
            ->add('groupe', EntityType::class, array(
                'class' => Group::class,
                'expanded' => false,
                'multiple' => false,
                'required' => true,
                'attr' => array(
                    'class' => 'form-control select-search',
                ),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
