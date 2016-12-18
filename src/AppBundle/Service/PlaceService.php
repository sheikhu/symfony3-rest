<?php
/**
 * Created by PhpStorm.
 * User: sheikhu
 * Date: 18/12/16
 * Time: 16:04
 */

namespace AppBundle\Service;


use AppBundle\Controller\PlaceDTO;
use AppBundle\Entity\Place;
use Doctrine\Common\Persistence\ObjectManager;

class PlaceService
{
    /**
     * @var ObjectManager
     */
    protected $entityManager;

    /**
     * PlaceService constructor.
     * @param ObjectManager $entityManager
     */
    public function __construct(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function fetchPlaces()
    {
        return $this->entityManager
            ->getRepository(Place::class)
            ->findAll();
    }

    public function getPlace($placeId)
    {
        return $this->entityManager
            ->getRepository(Place::class)
            ->find($placeId);
    }

    public function createPlace(Place $place) {
        $this->entityManager->persist($place);
        $this->entityManager->flush();

        return $place;
    }

    public function createPlaceFromDto(PlaceDto $placeDto) {
        $place = new Place();

        $place->setName($placeDto->getName());
        $place->setAddress($placeDto->getAddress());

        $place = $this->createPlace($place);

        return $place;
    }
    /**
     * @param ObjectManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }
}