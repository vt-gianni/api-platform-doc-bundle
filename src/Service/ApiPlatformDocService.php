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

            foreach ($resourceMetadata->getItemOperations() as $operationName => $operation) {
                foreach ($allRoutes as $routeName => $route) {
                    if (strpos($route->getPath(), $resourceName) !== false) {
                        // Ici, nous vérifions simplement si le chemin de la route contient le nom de la ressource.
                        // Vous pouvez adapter la logique pour mieux correspondre à vos besoins.
                        $resourceMetadata->getItemOperations()[$operationName]['route'] = $route->getPath();
                    }
                }
            }

            foreach ($resourceMetadata->getCollectionOperations() as $operationName => $operation) {
                foreach ($allRoutes as $routeName => $route) {
                    if (strpos($route->getPath(), $resourceName) !== false) {
                        $resourceMetadata->getCollectionOperations()[$operationName]['route'] = $route->getPath();
                    }
                }
            }

            $resources[$resourceName] = $resourceMetadata;
        }

        return $resources;
    }

}
