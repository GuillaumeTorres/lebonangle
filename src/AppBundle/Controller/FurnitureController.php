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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Furniture;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FurnitureController
 * @package AppBundle\Controller
 */
class FurnitureController extends Controller
{
    /**
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of all the furnitures.",
     *     @SWG\Schema(
     *          type="array",
     *          @Model(type=Furniture::class)
     *      )
     * )
     *
     * @SWG\Tag(name="Furnitures")
     *
     * @return \AppBundle\Entity\Furniture[]|array
     */
    public function getFurnituresAction()
    {
        return $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Furniture')
            ->findAll();
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Returns the furniture with the specified id.",
     *     @SWG\Schema(
     *          type="array",
     *          @Model(type=Furniture::class)
     *      )
     * )
     *
     * @SWG\Tag(name="Furnitures")
     *
     * @Rest\Get("/furniture/{id}", name="furniture")
     *
     * @param integer $id
     *
     * @return JsonResponse
     */
    public function getFurnitureAction($id)
    {
        return $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Furniture')
            ->findOneBy(array('id' => $id));
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
