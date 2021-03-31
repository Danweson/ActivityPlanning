<?php

namespace App\Form;

use App\Entity\Activity;
use App\Entity\Category;
use App\Entity\Group;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextType::class, array(
                'attr' => array(
                    'autofocus' => false,
                    'class' => 'form-control',
                    'placeholder' => 'content',
                ),
                'trim' => true,
                'required' => true,
            ))
            ->add('startDate', DateType::class, [
                'widget' => 'single_text',

                'attr' => array(
                    'class' => 'form-control daterange-single',
                    'id' => 'anytime-month-numeric'
                ),
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text',

                'attr' => array(
                    'class' => 'form-control daterange-single',
                    'id' => 'anytime-month-numeric'
                ),
            ])
            ->add('isNotificated', ChoiceType::class, [
                'choices' => [
                    'Yes' => true,
                    'No' => false
                ],
                'attr' => array(
                    'autofocus' => false,
                    'class' => 'form-control',
                ),
            ])
            ->add('category', EntityType::class, array(
                'class' => Category::class,
                'expanded' => false,
                'multiple' => false,
                'required' => true,
                'attr' => array(
                    'class' => 'form-control select-search',
                ),
            ))
            ->add('groups', EntityType::class, array(
                'class' => Group::class,
                'expanded' => false,
                'multiple' => true,
                'required' => true,
                'attr' => array(
                    'class' => 'form-control multiselect',
                ),
            ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Activity::class,
        ]);
    }
}
