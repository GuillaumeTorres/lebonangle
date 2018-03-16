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
use AppBundle\Entity\Furniture;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;



use AppBundle\Service\RequestService;
use AppBundle\Service\UserService;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use AppBundle\Entity\Request as RequestEntity;
/**
 * Class FurnitureController
 *
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
     * @return RequestEntity[]|array|JsonResponse
     */
    public function cgetAction()
    {
        //$userId = $this->getUser()->getId();
        try {
            $furniture = $this->furnitureService->getFurnitures();
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 401);
        }

        return $furniture;
    }

    /**
     * @return RequestEntity[]|array|JsonResponse
     */
    public function getAction($id)
    {
        //$userId = $this->getUser()->getId();
        try {
            $furniture = $this->furnitureService->getById($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 401);
        }

        return $furniture;
    }

    /**
     *
     * @SWG\Response(
     *     response=200,
     *     description="Creates a new furniture.",
     *     @SWG\Schema(
     *          type="array",
     *          @Model(type=Furniture::class)
     *      )
     * )
     *
     * @SWG\Tag(name="Furnitures")
     *
     * @Rest\Post("/create_furniture", name="createFurniture")
     *
     * @param Request $request
     *
     * @return Furniture
     */
    public function createFurnitureAction(Request $request)
    {
        $title       = $request->get('title');
        $description = $request->get('description');
        $width       = $request->get('width');
        $height      = $request->get('height');
        $depth       = $request->get('depth');
        $angle       = $request->get('angle');

        /** @var Furniture $furniture */
        $furniture = new Furniture();

        $furniture->setTitle($title);
        $furniture->setDescription($description);
        $furniture->setWidth($width);
        $furniture->setHeight($height);
        $furniture->setDepth($depth);
        $furniture->setAngle($angle);

        return $furniture;
    }
}
