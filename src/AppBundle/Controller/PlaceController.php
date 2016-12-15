<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Place;
use Symfony\Component\HttpFoundation\Response as HttpStatus;
use Symfony\Component\VarDumper\VarDumper;
use FOS\RestBundle\Controller\Annotations as Rest;

class PlaceController extends ApiController
{

    /**
     * @Rest\View()
     * @Get("places")
     */
    public function getPlacesAction(Request $request)
    {

        $places = $this->getDoctrine()->getManager()
                ->getRepository(Place::class)
                ->findAll();

        return $places;
    }

    /**
     * @Rest\View()
     * @Get("places/{id}")
     */
    public function getPlaceAction(Request $request, $id)
    {
        $place = $this->getDoctrine()->getManager()
            ->getRepository(Place::class)
            ->find($id);

        if($place == null)
            return $this->respondNotFound("Place <$id> not found");


        return $place;
    }
}
