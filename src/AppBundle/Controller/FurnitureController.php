<?php
/**
 * FurnitureController class file
 *
 * PHP Version 7.1
 *
 * @category Controller
 * @package  AppBundle\Controller
 */
namespace AppBundle\Controller;

use AppBundle\Form\RequestType;
use AppBundle\Service\FurnitureService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Furniture as FurnitureEntity;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use FOS\RestBundle\Controller\Annotations\RouteResource;

/**
 * Class FurnitureController
 *
 * @Rest\Route("/furniture", name="furniture_")
 */
class FurnitureController extends Controller
{
    private $furnitureService;

    /**
     * FurnitureController constructor.
     *
     * @param FurnitureService $furnitureService
     */
    public function __construct(FurnitureService $furnitureService)
    {
        $this->furnitureService = $furnitureService;
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of all the furnitures.",
     *     @SWG\Schema(
     *          type="array",
     *          @Model(type=FurnitureEntity::class)
     *      )
     * )
     *
     * @SWG\Tag(name="Furnitures")
     *
     * @Rest\Post(name="all")
     *
     * @return FurnitureEntity[]|array|JsonResponse
     */
    public function getAllAction()
    {
        try {
            $furniture = $this->furnitureService->getFurnitures();
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 401);
        }

        return $furniture;
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Creates a new furniture.",
     *     @SWG\Schema(
     *          type="array",
     *          @Model(type=FurnitureEntity::class)
     *      )
     * )
     *
     * @SWG\Tag(name="Furnitures")
     *
     * @Rest\Post("/create", name="create")
     *
     * @param Request $request
     *
     * @return FurnitureEntity|JsonResponse
     */
    public function createAction(Request $request)
    {
        $requestParameters = $request->request->all();

        try {
            $furnitureEntity = new FurnitureEntity();
            $furnitureEntity->setUser($this->getUser());

            if($this->submit($furnitureEntity, $requestParameters)) {
                $this->furnitureService->insertRequest($furnitureEntity);
            }
        } catch (\Exception $e){
            return new JsonResponse(['error' => $e->getMessage()], 401);
        }

        return $furnitureEntity;
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Modifies the furniture with the specified id.",
     *     @SWG\Schema(
     *          type="array",
     *          @Model(type=FurnitureEntity::class)
     *      )
     * )
     *
     * @SWG\Tag(name="Furnitures")
     *
     * @Rest\Put("/edit/{id}", name="edit")
     *
     * @param Request         $request
     * @param FurnitureEntity $furnitureEntity
     *
     * @return FurnitureEntity|JsonResponse
     */
    public function putAction(Request $request, FurnitureEntity $furnitureEntity)
    {
        $requestParameters = $request->request->all();

        try {
            if ($this->submit($furnitureEntity, $requestParameters)) {
                $this->furnitureService->insertRequest($furnitureEntity);
            }
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 401);
        }

        return $furnitureEntity;
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Returns the furniture with the specified id.",
     *     @SWG\Schema(
     *          type="array",
     *          @Model(type=FurnitureEntity::class)
     *      )
     * )
     *
     * @SWG\Tag(name="Furnitures")
     *
     * @Rest\Get("/furniture/{id}", name="furniture")
     *
     * @return FurnitureEntity[]|array|JsonResponse
     */
    public function getAction($id)
    {
        try {
            $furniture = $this->furnitureService->getById($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 401);
        }

        return $furniture;
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Deletes a furniture.",
     *     @SWG\Schema(
     *          type="array",
     *          @Model(type=FurnitureEntity::class)
     *      )
     * )
     *
     * @SWG\Tag(name="Furnitures")
     *
     * @Rest\Delete("/delete/{id}", name="delete")
     *
     * @param integer $id
     *
     * @return JsonResponse
     */
    public function deleteAction($id)
    {
        try {
            $this->furnitureService->deleteFurniture($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 401);
        }

        return new JsonResponse(['Success' => 'Resource deleted successfully'], 200);
    }

    /**
     * @param FurnitureEntity $furnitureEntity
     * @param array         $parameters
     *
     * @return boolean
     */
    private function submit($furnitureEntity, $parameters)
    {
        $form = $this->createForm(RequestType::class, $furnitureEntity);
        $form->submit($parameters);

        if ($form->isSubmitted()) {
            return true;
        }

        return false;
    }

}
