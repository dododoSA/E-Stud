<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="four_choice_quizzes")
 */

class FourChoiceQuiz {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Assert\NotNull
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotNull
     */
    private $quiz_num;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotNull
     */
    private $question;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotNull
     */
    private $correct_ans;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotNull
     */
    private $wrong_ans1;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotNull
     */
    private $wrong_ans2;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotNull
     */
    private $wrong_ans3;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotNull
     */
    private $course_id;
}