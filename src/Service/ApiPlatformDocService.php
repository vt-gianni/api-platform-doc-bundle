<?php

namespace VTGianni\ApiPlatformDocBundle\Service;

use ApiPlatform\Core\Metadata\Resource\Factory\AnnotationResourceMetadataFactory;
use ApiPlatform\Core\Metadata\Resource\Factory\AnnotationResourceNameCollectionFactory;
use ApiPlatform\Exception\ResourceClassNotFoundException;

class ApiPlatformDocService
{
    private AnnotationResourceNameCollectionFactory $resourceNameCollectionFactory;
    private AnnotationResourceMetadataFactory $resourceMetadataFactory;

    public function __construct(AnnotationResourceNameCollectionFactory $resourceNameCollectionFactory, AnnotationResourceMetadataFactory $resourceMetadataFactory)
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
