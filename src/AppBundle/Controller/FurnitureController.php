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
 * @RouteResource("Furniture")
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
     * @return FurnitureEntity[]|array|JsonResponse
     */
    public function cgetAction()
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
     *     description="Creates a new furniture.",
     *     @SWG\Schema(
     *          type="array",
     *          @Model(type=FurnitureEntity::class)
     *      )
     * )
     *
     * @SWG\Tag(name="Furnitures")
     *
     * @Rest\Post("/create_furniture", name="createFurniture")
     *
     * @param Request $request
     *
     * @return FurnitureEntity|JsonResponse
     */
    public function postCreateAction(Request $request)
    {
        $requestParameters = $request->request->all();
        try {
            $furnitureEntity = $this->furnitureService->createFurniture($this->getUser(), $requestParameters);
        } catch (\Exception $e){
            return new JsonResponse(['error' => $e->getMessage()], 401);
        }
        return $furnitureEntity;
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
     * @Rest\Delete("/delete_furniture/{id}", name="deleteFurniture")
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

}
