<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{

    public function getUsersAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $users = $entityManager->getRepository('AppBundle:User')->findAll();

        return $users;
    }
}
