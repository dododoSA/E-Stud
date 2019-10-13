<?php

namespace AppBundle\Entity\FourChoiceQuiz;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="courses")
 */

class Course {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotNull
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotNull
     */
    private $genre_name;

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
     * Set name
     *
     * @param string $name
     *
     * @return FourCourse
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set genreName
     *
     * @param string $genreName
     *
     * @return FourCourse
     */
    public function setGenreName($genreName)
    {
        $this->genre_name = $genreName;

        return $this;
    }

    /**
     * Get genreName
     *
     * @return string
     */
    public function getGenreName()
    {
        return $this->genre_name;
    }
}
