<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Place;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class PlaceController extends ApiController
{

    /**
     * @Rest\View()
     * @Get("places")
     * @return array
     */
    public function getPlacesAction()
    {

        $places = $this->getDoctrine()->getManager()
                ->getRepository(Place::class)
                ->findAll();

        return $places;
    }

    /**
     * @Rest\View()
     * @Get("places/{id}")
     * @param $id
     * @return object|JsonResponse
     */
    public function getPlaceAction($id)
    {
        $place = $this->getDoctrine()->getManager()
            ->getRepository(Place::class)
            ->find($id);

        if($place == null)
            return $this->respondNotFound("Place <$id> not found");


        return $place;
    }

    /**
     * @Rest\View()
     * @Rest\Post("/places")
     * @param PlaceDTO $placeDTO
     * @param ConstraintViolationListInterface $validationErrors
     * @return PlaceDTO|ArrayCollection
     */
    public function createPlacesAction(PlaceDTO $placeDTO, ConstraintViolationListInterface $validationErrors)
    {
        if(count($validationErrors) > 0) {
            $errors = new ArrayCollection();

            /** @var ConstraintViolation $error */
            foreach ($validationErrors as $error) {
                //VarDumper::dump($error)
                $errors->add([
                    'message'   =>  $error->getMessage(),
                    'propertyPath'  =>  $error->getPropertyPath()
                ]);
            }

            return $errors;
        }

        return $placeDTO;
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