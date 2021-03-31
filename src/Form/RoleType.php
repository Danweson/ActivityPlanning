<?php

namespace App\Form;

use App\Entity\Profile;
use App\Entity\Role;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'attr' => array(
                    'autofocus' => false,
                    'class' => 'form-control',
                    'placeholder' => 'name',
                ),
                'trim' => true,
                'required' => true,
            ))
            ->add('route', TextType::class, array(
                'attr' => array(
                    'autofocus' => false,
                    'class' => 'form-control',
                    'placeholder' => 'route',
                ),
                'trim' => true,
                'required' => true,
            ))
            ->add('icon', TextType::class, array(
                'attr' => array(
                    'autofocus' => false,
                    'class' => 'form-control',
                    'placeholder' => 'icon',
                ),
                'trim' => true,
                'required' => true,
            ))
            ->add('menu', EntityType::class, array(
                'class' => Role::class,
                'expanded' => false,
                'multiple' => false,
                'required' => false,
                'attr' => array(
                    'class' => 'form-control select-search',
                ),
            ))
            ->add('profiles', EntityType::class, array(
                'class' => Profile::class,
                'expanded' => false,
                'multiple' => true,
                'required' => true,
                'attr' => array(
                    'class' => 'form-control multiselect',
                ),
            ))
            ->add('user', EntityType::class, array(
                'class' => User::class,
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
            'data_class' => Role::class,
        ]);
    }
}
