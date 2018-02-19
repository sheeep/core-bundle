<?php

declare(strict_types=1);

/*
 * This file is part of Contao.
 *
 * Copyright (c) 2005-2018 Leo Feyer
 *
 * @license LGPL-3.0+
 */

namespace Contao\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Makes services public that we need to retrieve directly.
 */
class MakeServicesPublicPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        $services = ['security.firewall.map', 'security.logout_url_generator'];

        foreach ($services as $service) {
            if (!$container->hasDefinition($service)) {
                continue;
            }

            $container->getDefinition($service)->setPublic(true);
        }
    }
}
