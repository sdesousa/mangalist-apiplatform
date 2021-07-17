<?php

namespace App\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ExceptionNormalizerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $exceptionListenerDefinition = $container->findDefinition('mangalist_api.events.exception_subscriber');
        $normalizers = $container->findTaggedServiceIds('mangalist_api.normalizer');

        foreach ($normalizers as $normalizer => $tags) {
            $exceptionListenerDefinition->addMethodCall('addNormalizer', [new Reference($normalizer)]);
        }
    }
}
