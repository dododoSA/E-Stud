<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM|Entity
 * @ORM|Table(name="four_choice_quizzes")
 */

class FourChoiceQuize {
    /**
     * @ORM|Column(type="integer")
     * @ORM|Id
     * @ORM|GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM|Column(type="integer")
     */
    private $quiz_num;

    /**
     * @ORM|Column(type="string")
     */
    private $quiestion;

    /**
     * @ORM|Column(type="string")
     */
    private $correct_ans;

    /**
     * @ORM|Column(type="string")
     */
    private $wrong_ans1;
}