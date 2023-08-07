<?php

namespace VTGianni\ApiPlatformDocBundle\Service;

use ApiPlatform\Exception\ResourceClassNotFoundException;
use ApiPlatform\Metadata\Resource\Factory\ResourceNameCollectionFactoryInterface;
use ApiPlatform\Core\Metadata\Resource\Factory\ResourceMetadataFactoryInterface;

class ApiPlatformDocService
{
    private $resourceNameCollectionFactory;
    private $resourceMetadataFactory;

    public function __construct(ResourceNameCollectionFactoryInterface $resourceNameCollectionFactory, ResourceMetadataFactoryInterface $resourceMetadataFactory)
    {
        $this->resourceNameCollectionFactory = $resourceNameCollectionFactory;
        $this->resourceMetadataFactory = $resourceMetadataFactory;
    }

    /**
     * @return array
     * @throws ResourceClassNotFoundException
     */
    public function getMetaData(): array
    {
        $resourceNames = $this->resourceNameCollectionFactory->create();
        $resources = [];
        foreach ($resourceNames as $resourceName) {
            $resources[$resourceName] = $this->resourceMetadataFactory->create($resourceName);
        }
        return $resources;
    }
}
