<?php

namespace AppBundle\Form\FourChoiceQuiz;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class FourChoiceQuizType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('question')
            ->add('correct_ans')
            ->add('wrong_ans1')
            ->add('wrong_ans2')
            ->add('wrong_ans3')
            ->add('save', SubmitType::class);
    }
}