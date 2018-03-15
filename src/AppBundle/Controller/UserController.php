<?php
/**
 * UserController class file
 *
 * PHP Version 7.1
 *
 * @category Controller
 *
 * @package  AppBundle\Controller
 */
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class UserController
 */
class UserController extends Controller
{
    private $userService;

    /**
     * UserController constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

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
        try {
            $user = $this->userService->authUser($username, $password);
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['error' => $e->getMessage()], 401);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
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
        $userParameters = $request->request->all();

        try {
            $user = $this->userService->createUser($userParameters);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 401);
        }
        $jsonUser = $user->jsonSerialize();

        $token = $this->get('lexik_jwt_authentication.encoder')->encode([
            'username' => $user->getUsername(),
        ]);

        return new JsonResponse($jsonUser, 200, ['Authorization' => 'Bearer '.$token]);
    }
}
