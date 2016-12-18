<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Place;
use AppBundle\Form\PlaceType;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\VarDumper\VarDumper;

class PlaceController extends ApiController
{

    /**
     * @Rest\View()
     * @Get("places")
     * @return array
     */
    public function getPlacesAction()
    {
        $placeService = $this->get('place_service');

        return $placeService->fetchPlaces();
    }

    /**
     * @Rest\View()
     * @Get("places/{id}")
     * @param $id
     * @return object|JsonResponse
     */
    public function getPlaceAction($id)
    {
        $placeService = $this->get('place_service');

        $place = $placeService->getPlace($id);

        if($place == null)
            return $this->respondNotFound("Place <$id> not found");


        return $place;
    }

    /**
     * @Rest\View()
     * @Rest\Post("/places")
     * @param Request $request
     * @param PlaceDTO $placeDto
     * @return PlaceDTO|ArrayCollection
     * @internal param CreatePlaceRequest $placeRequest
     * @internal param ConstraintViolationListInterface $validationErrors
     * @internal param PlaceDTO $placeDTO
     */
    public function createPlacesAction(Request $request, PlaceDTO $placeDto)
    {

        $place = new Place();
        $placeForm = $this->createForm(PlaceType::class, $place);

        $placeForm->submit($request->request->all());

        if(!$placeForm->isValid()) {
            return $this->setStatusCode(Response::HTTP_BAD_REQUEST)
                ->respond($placeForm);
        }

        $placeService = $this->get('place_service');
        $place = $placeService->createPlace($place);

        return $place;
    }



}

class CreatePlaceRequest {

    /**
     * @var PlaceDTO
     * @Assert\Valid()
     * @Assert\NotNull()
     */
    protected $place;

    /**
     * @return mixed
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param mixed $place
     */
    public function setPlace($place)
    {
        $this->place = $place;
    }


}
class PlaceDTO {
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="5")
     */
    protected $name;

    /**
     * @Assert\NotBlank()
     */
    protected $address;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }


}