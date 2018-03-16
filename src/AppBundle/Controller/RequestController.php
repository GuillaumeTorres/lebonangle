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

use AppBundle\Form\RequestType;
use AppBundle\Service\RequestService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Request as RequestEntity;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class RequestController
 *
 * @Rest\Route("/request", name="request_")
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
     * @Rest\Post(name="all")
     *
     * @return RequestEntity[]|array|JsonResponse
     */
    public function getAllAction()
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
     * @Rest\Post("/create", name="create")
     *
     * @param Request $request
     *
     * @return RequestEntity|JsonResponse
     */
    public function createAction(Request $request)
    {
        $requestParameters = $request->request->all();

        try {
            $requestEntity = new RequestEntity();
            $requestEntity->setUser($this->getUser());

            if ($this->submit($requestEntity, $requestParameters)) {
                $this->requestService->insertRequest($requestEntity);
            }
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 401);
        }

        return $requestEntity;
    }

    /**
     * @Rest\Put("/edit/{id}", name="edit")
     *
     * @param Request       $request
     * @param RequestEntity $requestEntity
     *
     * @return RequestEntity|JsonResponse
     */
    public function putAction(Request $request, RequestEntity $requestEntity)
    {
        $requestParameters = $request->request->all();

        try {
            if ($this->submit($requestEntity, $requestParameters)) {
                $this->requestService->insertRequest($requestEntity);
            }
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 401);
        }

        return $requestEntity;
    }

    /**
     * @Rest\Delete("/delete/{id}", name="delete")
     *
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

    /**
     * @param RequestEntity $requestEntity
     * @param array         $parameters
     *
     * @return boolean
     */
    private function submit($requestEntity, $parameters)
    {
        $form = $this->createForm(RequestType::class, $requestEntity);
        $form->submit($parameters);

        if ($form->isSubmitted()) {
            return true;
        }

        return false;
    }
}
