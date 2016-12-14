<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Place;
use Symfony\Component\HttpFoundation\Response as HttpStatus;

class PlaceController extends ApiController
{

    /**
     * @Route("/places", name="places_list")
     * @Method({"GET"})
     */
    public function getPlacesAction(Request $request)
    {

        $places = $this->getDoctrine()->getManager()
                ->getRepository(Place::class)
                ->findAll();

        return $this->json($places);
    }

    /**
     * @Route("/places/{id}", name="places_one", requirements={"place_id" = "\d+"})
     * @Method({"GET"})
     */
    public function getPlaceAction(Request $request, $id)
    {
        $place = $this->getDoctrine()->getManager()
            ->getRepository(Place::class)
            ->find($id);

        if($place == null)
            return $this->respondNotFound("Place <$id> not found");


        return $this->respond($place);
    }
}
