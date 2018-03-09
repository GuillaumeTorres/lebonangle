<?php
/**
 * UserController class file
 *
 * PHP Version 7.1
 *
 * @category Controller
 * @package  AppBundle\Controller
 */
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class UserController
 * @package AppBundle\Controller
 */
class UserController extends Controller
{
    /**
     * @return \AppBundle\Entity\User[]|array
     */
    public function getUsersAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $users = $entityManager->getRepository('AppBundle:User')->findAll();

        return $users;
    }

    /**
     * @Rest\Post("/login", name="login")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function loginAction(Request $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');

        /** @var User $user */
        $user = $this->get('fos_user.user_manager')->findUserBy(array('username' => $username));
        $encoder = $this->get('security.encoder_factory')->getEncoder($user);
        if (!$user || !$encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())) {
            return new JsonResponse('Invalid username/password', 401);
        }
        $jsonUser = $user->jsonSerialize();

        $token = $this->get('lexik_jwt_authentication.encoder')->encode([
            'username' => $user->getUsername(),
        ]);

        return new JsonResponse($jsonUser, 200, ['Authorization' => 'Bearer '.$token]);
    }

    /**
     * @Rest\Post("/register", name="register")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function registerAction(Request $request)
    {
        $username  = $request->get('username');
        $firstName = $request->get('first_name');
        $lastName  = $request->get('last_name');
        $email     = $request->get('email');
        $type      = $request->get('type');
        $password  = $request->get('password');

        $userManager = $this->get('fos_user.user_manager');

        /** @var User $user */
        $user = $userManager->createUser();
        $user->setUsername($username);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setEmail($email);
        $user->setType(strtoupper($type));
        $user->setPlainPassword($password);
        $user->setEnabled(true);

        $userManager->updateUser($user);
        $jsonUser = $user->jsonSerialize();

        $token = $this->get('lexik_jwt_authentication.encoder')->encode([
            'username' => $user->getUsername(),
        ]);

        return new JsonResponse($jsonUser, 200, ['Authorization' => 'Bearer '.$token]);
    }
}
