<?php

declare(strict_types=1);

/*
 * This file is part of Contao.
 *
 * Copyright (c) 2005-2018 Leo Feyer
 *
 * @license LGPL-3.0+
 */

namespace Contao\CoreBundle\Tests\DependencyInjection\Compiler;

use Contao\CoreBundle\DependencyInjection\Compiler\MakeServicesPublicPass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class MakeServicesPublicPassTest extends TestCase
{
    public function testCanBeInstantiated(): void
    {
        $pass = new MakeServicesPublicPass();

        $this->assertInstanceOf('Contao\CoreBundle\DependencyInjection\Compiler\MakeServicesPublicPass', $pass);
    }

    public function testMakesTheServicesPublic(): void
    {
        $services = ['security.firewall.map', 'security.logout_url_generator'];
        $container = new ContainerBuilder();

        foreach ($services as $service) {
            $container->setDefinition($service, new Definition());
        }

        $pass = new MakeServicesPublicPass();
        $pass->process($container);

        foreach ($services as $service) {
            $this->assertTrue($container->getDefinition($service)->isPublic());
        }
    }
}
