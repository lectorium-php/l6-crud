<?php

namespace App\Form;

use App\Entity\CourseWork;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseWorkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('body')
        ;

        if ($options['is_admin']) {
            $builder
                ->add('student');
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'is_admin' => false,
            'data_class' => CourseWork::class,
        ]);
    }
}
