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

        foreach ($resourceNames as $resourceName) {
            $resourceMetadata = $this->resourceMetadataFactory->create($resourceName);

            $routes = [];

            foreach ($resourceMetadata->getCollectionOperations() as $operationName => $operation) {
                try {
                    $routeName = $this->routeNameResolver->getRouteName($resourceName, true);
                    $routes['collection'][$operationName] = $this->router->generate($routeName);
                } catch (\Exception $e) {
                }
            }

            foreach ($resourceMetadata->getItemOperations() as $operationName => $operation) {
                try {
                    $routeName = $this->routeNameResolver->getRouteName($resourceName, true);
                    $routes['item'][$operationName] = $this->router->generate($routeName);
                } catch (\Exception $e) {
                }
            }


            $resources[$resourceName] = [
                'metadata' => $resourceMetadata,
                'routes' => $routes
            ];
        }

        return $resources;
    }
}
