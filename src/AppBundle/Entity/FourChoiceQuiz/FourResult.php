<?php

namespace AppBundle\Entity\FourChoiceQuiz;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="four_result")
 */
class FourResult {
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
    private $userId;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotNull
     */
    private $fourQuizId;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotNull
     */
    private $result;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotNull
     */
    private $date;

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
     * Set userId
     *
     * @param integer $userId
     *
     * @return FourResult
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set fourQuizId
     *
     * @param integer $fourQuizId
     *
     * @return FourResult
     */
    public function setFourQuizId($fourQuizId)
    {
        $this->fourQuizId = $fourQuizId;

        return $this;
    }

    /**
     * Get fourQuizId
     *
     * @return integer
     */
    public function getFourQuizId()
    {
        return $this->fourQuizId;
    }

    /**
     * Set result
     *
     * @param string $result
     *
     * @return FourResult
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return FourResult
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}
