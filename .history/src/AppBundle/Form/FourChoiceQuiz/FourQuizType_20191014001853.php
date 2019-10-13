<?php

namespace AppBundle\Form\FourChoiceQuiz;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class FourQuizType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('question')
            ->add('quizNum')
            ->add('correctAns')
            ->add('wrongAns1')
            ->add('wrongAns2')
            ->add('wrongAns3')
            ->add('save', SubmitType::class);
    }
}