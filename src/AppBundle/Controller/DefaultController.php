<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $userRepository = $em->getRepository('AppBundle:User');
        $user = $userRepository->getUserTasks($user);
        $tasks = [];
        $nextTaskId = 1;
        if(!is_null($user)){
            $tasks = $user->getUserTasks();
            $nextTaskId = $tasks[sizeof($tasks)-1]->getItemId() + 1;
        }
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $task->setUserId($this->getUser());
            $task->setItemId($nextTaskId);
            $task->setScheduled(new \DateTime(date('Y-m-d H:i:s', strtotime($task->getScheduled()))));
            $task->setCompletion(new \DateTime());
            $task->setTimestamp(new \DateTime());
            $task->setDone(false);
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
            return $this->redirectToRoute('homepage');
        }

        return $this->render('AppBundle:default:index.html.twig', [
            'form' => $form->createView(),
            'tasks' => $tasks,
        ]);
    }

    public function markAsCompletedAction(Task $task)
    {
        $em = $this->getDoctrine()->getManager();
        $task->setCompletion(new \DateTime());
        $task->setDone(true);
        $em->persist($task);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }

    public function deleteItemAction(Task $task)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }

    public function showCredentialsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $userRepository = $em->getRepository('AppBundle:User');
        $users = $userRepository->findAll();
        $user = $users[array_rand($users)];

        return $this->render('AppBundle:partials:show_credentials.html.twig', [
            'username' => $user->getUsername(),
            'password' => $user->getUsername(),
        ]);
    }

    public function aboutAction()
    {
        return $this->render('AppBundle:default:about.html.twig');
    }
}
