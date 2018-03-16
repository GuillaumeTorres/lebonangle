<?php
/**
 * RequestController class file
 *
 * PHP Version 7.1
 *
 * @category Controller
 *
 * @package  AppBundle\Controller
 */
namespace AppBundle\Controller;

use AppBundle\Service\RequestService;
use AppBundle\Service\UserService;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Request as RequestEntity;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class RequestController
 *
 *
 * @RouteResource("Request")
 */
class RequestController extends Controller
{
    private $requestService;

    /**
     * RequestController constructor.
     *
     * @param RequestService $requestService
     */
    public function __construct(RequestService $requestService)
    {
        $this->requestService = $requestService;
    }

    /**
     * @return RequestEntity[]|array|JsonResponse
     */
    public function cgetAction()
    {
        $userId = $this->getUser()->getId();
        try {
            $requests = $this->requestService->getByUser($userId);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 401);
        }

        return $requests;
    }

    /**
     * @param Request $request
     *
     * @return RequestEntity|JsonResponse
     */
    public function createAction(Request $request)
    {
        $requestParameters = $request->request->all();
        try {
            $requestEntity = $this->requestService->createRequest($this->getUser(), $requestParameters);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 401);
        }

        return $requestEntity;
    }

    /**
     * @param integer $id
     *
     * @return JsonResponse
     */
    public function deleteAction($id)
    {
        try {
            $this->requestService->deleteRequest($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 401);
        }

        return new JsonResponse(['Success' => 'Resource deleted successfully'], 200);
    }
}
