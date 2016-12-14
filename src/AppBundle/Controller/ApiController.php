<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use \Symfony\Component\HttpFoundation\Response as ApiResponse;

class ApiController extends Controller
{

    protected $statusCode = ApiResponse::HTTP_OK;

    protected function respondWithSuccess($data)
    {
        return $this->respond($data);
    }

    protected function respondNotFound($message = 'Not found')
    {
        return $this->setStatusCode(ApiResponse::HTTP_NOT_FOUND)
            ->respondWithError($message);
    }

    protected function respondInternalError($message = 'Internal Error Server')
    {
        return $this->setStatusCode(ApiResponse::HTTP_INTERNAL_SERVER_ERROR)
            ->respondWithError($message);
    }

    protected function respondUnauthorized($message)
    {
        return $this->setStatusCode(ApiResponse::HTTP_UNAUTHORIZED)
            ->respondWithError($message);
    }

    private function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'statusCode' => $this->getStatusCode()
            ]
        ]);
    }

    protected function respond($data, $headers=[])
    {
        return $this->json($data, $this->getStatusCode(), $headers);
    }
    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }
}
