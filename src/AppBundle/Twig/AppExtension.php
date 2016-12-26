<?php

namespace AppBundle\Twig;

use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Logging\DebugStack;

class AppExtension extends \Twig_Extension
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var DebugStack
     */
    protected $debugStack;

    /**
     * AppExtension constructor.
     * @param EntityManager $entityManager
     */
    function __construct(EntityManager $entityManager, DebugStack $debugStack)
    {
        $this->entityManager = $entityManager;
        $this->debugStack = $debugStack;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('request_time', [$this, 'requestTime'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('query_time', [$this, 'queryTime'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('user_count', [$this, 'userCount'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('task_count', [$this, 'taskCount'], ['is_safe' => ['html']]),
        ];
    }

    public function requestTime($decimals = 0)
    {
        return number_format((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'])*1000, $decimals);
    }

    public function queryTime()
    {
            return array_sum(array_column($this->debugStack->queries, 'executionMS'))*1000;
    }

    public function userCount()
    {
        $em = $this->entityManager;
        $user_count = $em->getRepository('AppBundle:User')->count();

        return $user_count;
    }

    public function taskCount()
    {
        $em = $this->entityManager;
        $task_count = $em->getRepository('AppBundle:Task')->count();

        return $task_count;
    }

    public function getName()
    {
        return 'app_extension';
    }
}