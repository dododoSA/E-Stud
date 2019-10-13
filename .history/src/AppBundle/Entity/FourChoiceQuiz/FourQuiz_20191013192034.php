<?php
namespace AppBundle\Entity\FourChoiceQuiz;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="four_quizzes")
 */

class FourQuiz {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotNull
     */
    private $quiz_num;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotNull
     */
    private $question;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotNull
     */
    private $correct_ans;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotNull
     */
    private $wrong_ans1;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotNull
     */
    private $wrong_ans2;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotNull
     */
    private $wrong_ans3;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotNull
     */
    private $four_course_id;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set quizNum
     *
     * @param integer $quizNum
     *
     * @return FourQuiz
     */
    public function setQuizNum($quizNum)
    {
        $this->quiz_num = $quizNum;

        return $this;
    }

    /**
     * Get quizNum
     *
     * @return integer
     */
    public function getQuizNum()
    {
        return $this->quiz_num;
    }

    /**
     * Set question
     *
     * @param string $question
     *
     * @return FourQuiz
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set correctAns
     *
     * @param string $correctAns
     *
     * @return FourQuiz
     */
    public function setCorrectAns($correctAns)
    {
        $this->correct_ans = $correctAns;

        return $this;
    }

    /**
     * Get correctAns
     *
     * @return string
     */
    public function getCorrectAns()
    {
        return $this->correct_ans;
    }

    /**
     * Set wrongAns1
     *
     * @param string $wrongAns1
     *
     * @return FourQuiz
     */
    public function setWrongAns1($wrongAns1)
    {
        $this->wrong_ans1 = $wrongAns1;

        return $this;
    }

    /**
     * Get wrongAns1
     *
     * @return string
     */
    public function getWrongAns1()
    {
        return $this->wrong_ans1;
    }

    /**
     * Set wrongAns2
     *
     * @param string $wrongAns2
     *
     * @return FourQuiz
     */
    public function setWrongAns2($wrongAns2)
    {
        $this->wrong_ans2 = $wrongAns2;

        return $this;
    }

    /**
     * Get wrongAns2
     *
     * @return string
     */
    public function getWrongAns2()
    {
        return $this->wrong_ans2;
    }

    /**
     * Set wrongAns3
     *
     * @param string $wrongAns3
     *
     * @return FourQuiz
     */
    public function setWrongAns3($wrongAns3)
    {
        $this->wrong_ans3 = $wrongAns3;

        return $this;
    }

    /**
     * Get wrongAns3
     *
     * @return string
     */
    public function getWrongAns3()
    {
        return $this->wrong_ans3;
    }

    /**
     * Set fourCourseId
     *
     * @param integer $fourCourseId
     *
     * @return FourQuiz
     */
    public function setFourCourseId($fourCourseId)
    {
        $this->four_course_id = $fourCourseId;

        return $this;
    }

    /**
     * Get fourCourseId
     *
     * @return integer
     */
    public function getFourCourseId()
    {
        return $this->four_course_id;
    }
}
