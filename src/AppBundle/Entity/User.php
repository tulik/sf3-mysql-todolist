<?php
namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="userId")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $userTasks;



    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUserTasks()
    {
        return $this->userTasks;
    }
}