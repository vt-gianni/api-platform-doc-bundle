<?php


namespace VTGianni\ApiPlatformDocBundle\Service;


use ApiPlatform\Core\Metadata\Resource\Factory\ResourceMetadataFactoryInterface;
use ApiPlatform\Exception\ResourceClassNotFoundException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ApiPlatformDocService
{
    private $bag;
    private $resourceMetadataFactory;

    public function __construct(ParameterBagInterface $bag, ResourceMetadataFactoryInterface $resourceMetadataFactory)
    {
        $this->bag = $bag;
        $this->resourceMetadataFactory = $resourceMetadataFactory;
    }

    /**
     * @return array
     * @throws ResourceClassNotFoundException
     */
    public function getMetaData(): array
    {
        $resourceClassNames = $this->bag->get('api_platform.resource_class_directories');

        $resources = [];
        foreach ($resourceClassNames as $resourceClassName) {
            try {
                $resources[$resourceClassName] = $this->resourceMetadataFactory->create($resourceClassName);
            } catch (ResourceClassNotFoundException $e) {
                // Ignorer si la classe n'est pas une ressource API Platform
            }
        }
        return $resources;
    }
}