<?php

namespace VTGianni\ApiPlatformDocBundle\Service;

use ApiPlatform\Exception\ResourceClassNotFoundException;
use ApiPlatform\Metadata\Resource\Factory\ResourceNameCollectionFactoryInterface;
use ApiPlatform\Core\Metadata\Resource\Factory\ResourceMetadataFactoryInterface;
use Symfony\Component\Routing\RouterInterface;
use ApiPlatform\Core\Api\OperationType;
use ApiPlatform\Core\Bridge\Symfony\Routing\RouteNameResolverInterface;

class ApiPlatformDocService
{
    private $resourceNameCollectionFactory;
    private $resourceMetadataFactory;
    private $router;
    private $routeNameResolver;

    public function __construct(
        ResourceNameCollectionFactoryInterface $resourceNameCollectionFactory,
        ResourceMetadataFactoryInterface $resourceMetadataFactory,
        RouterInterface $router,
        RouteNameResolverInterface $routeNameResolver
    ) {
        $this->resourceNameCollectionFactory = $resourceNameCollectionFactory;
        $this->resourceMetadataFactory = $resourceMetadataFactory;
        $this->router = $router;
        $this->routeNameResolver = $routeNameResolver;
    }

    public function getMetaData(): array
    {
        $resourceNames = $this->resourceNameCollectionFactory->create();
        $resources = [];

        $allRoutes = $this->router->getRouteCollection();

        foreach ($resourceNames as $resourceName) {
            $resourceMetadata = $this->resourceMetadataFactory->create($resourceName);

            $resourceArray = [
                'shortName' => $resourceMetadata->getShortName(),
                'description' => $resourceMetadata->getDescription(),
                'itemOperations' => [],
                'collectionOperations' => []
            ];

            foreach ($resourceMetadata->getItemOperations() as $operationName => $operation) {
                $resourceArray['itemOperations'][$operationName] = (array) $operation;
                foreach ($allRoutes->all() as $route) {
                    foreach ($route->getMethods() as $method) {
                        if (strtoupper($method) === strtoupper($operationName) && strpos($route->getDefault('_api_operation_name'), 'collection')  === false) {
                            $resourceArray['itemOperations'][$operationName]['route'] = str_replace('.{_format}', '', $route->getPath());
                        }
                    }
                }
            }

            foreach ($resourceMetadata->getCollectionOperations() as $operationName => $operation) {
                $resourceArray['collectionOperations'][$operationName] = (array) $operation;
                foreach ($allRoutes as $routeName => $route) {
                    foreach ($route->getMethods() as $method) {
                        if (strtoupper($method) === strtoupper($operationName) && strpos($route->getDefault('_api_operation_name'), 'collection')  !== false) {
                            $resourceArray['collectionOperations'][$operationName]['route'] = str_replace('.{_format}', '', $route->getPath());
                        }
                    }
                }
            }

            $resources[$resourceName] = $resourceArray;
        }

        return $resources;
    }


}
