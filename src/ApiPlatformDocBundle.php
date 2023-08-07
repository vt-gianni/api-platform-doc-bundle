<?php


namespace VTGianni\ApiPlatformDocBundle;


use Symfony\Component\HttpKernel\Bundle\Bundle;
use VTGianni\ApiPlatformDocBundle\DependencyInjection\ApiPlatformDocExtension;
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
}