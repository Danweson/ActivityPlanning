<?php

namespace App\Form;

use App\Entity\Profile;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ->add('username', TextType::class, array(
                'attr' => array(
                    'autofocus' => false,
                    'class' => 'form-control',
                    'placeholder' => 'prudence',
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
            ->add('password', PasswordType::class, array(
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'attr' => array(
                    'autofocus' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Password',
                ),
                'trim' => true,
                'required' => true,
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),

                ],

            ))
            ->add('profiles', EntityType::class, array(
                'class' => Profile::class,
                'expanded' => false,
                'multiple' => true,
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
            'data_class' => User::class,
        ]);
    }
}
