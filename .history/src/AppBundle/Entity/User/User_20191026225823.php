<?php

namespace AppBundle\Entity\User;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Role\Role;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */

class User implements UserInterface {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles = [];

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getRoles()
    {
        $roles = $this->roles;

        if (!in_array('ROLE_USER', $roles)) {
            $roles[] = 'ROLE_USER';
        }

        return $roles;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getPlainPassword() {
        return $this->plainPassword;
    }

    public function getSalt()
    {
        
    }

    public function eraseCredentials()
    {
        //パスワードがもれないようにログインが済んだらこれが呼ばれる
        $this->plainPassword = null;
    }

    public function setUsername($username) {
        $this->$username = $username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setPlainPassword($plainPassword) {
        $this->plainPassword = $plainPassword;

        $this->password = null;
    }
}