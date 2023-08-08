<?php


namespace VTGianni\ApiPlatformDocBundle\Controller;


use ApiPlatform\Exception\ResourceClassNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use VTGianni\ApiPlatformDocBundle\Service\ApiPlatformDocService;

class ApiPlatformDocController extends AbstractController
{
    private $service;

    public function __construct(ApiPlatformDocService $service)
    {
        $this->service = $service;
    }

    /**
     * @throws ResourceClassNotFoundException
     */
    public function index(): Response
    {
        dd($this->service->getMetaData());
        return $this->render('@ApiPlatformDoc/index.html.twig', [
            'resources' => $this->service->getMetaData()
        ]);
    }
}