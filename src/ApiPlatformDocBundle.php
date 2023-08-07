<?php


namespace VTGianni\ApiPlatformDocBundle;


use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use VTGianni\ApiPlatformDocBundle\DependencyInjection\ApiPlatformDocExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

class ApiPlatformDocBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new ApiPlatformDocExtension();
        }

        return $this->extension;
    }

    public function build(ContainerBuilder $builder)
    {
        parent::build($builder);
        $builder->addResource(new FileResource($this->getPath().'/Resources/config/routing.yaml'));
    }
}