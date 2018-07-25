<?php

declare(strict_types=1);

namespace Contao\CoreBundle\Security\Oauth;

use Http\Client\Common\HttpMethodsClient;
use HWI\Bundle\OAuthBundle\OAuth\RequestDataStorage\SessionStorage;
use HWI\Bundle\OAuthBundle\OAuth\RequestDataStorageInterface;
use HWI\Bundle\OAuthBundle\OAuth\ResourceOwnerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\HttpUtils;

class DynamicResourceOwnerFactory
{
    protected $container;
    protected $httpUtils;
    protected $httpClient;
    protected $storage;

    public function __construct(ContainerInterface $container, HttpUtils $httpUtils, HttpMethodsClient $httpClient, RequestDataStorageInterface $storage)
    {
        $this->container = $container;
        $this->httpUtils = $httpUtils;
        $this->httpClient = $httpClient;
        $this->storage = $storage;
    }

    public function create(string $name, string $type, array $options): ResourceOwnerInterface
    {
        $class = $this->container->getParameter(sprintf('hwi_oauth.resource_owner.%s.class', $type));

        $owner = new $class(
            $this->httpClient,
            $this->httpUtils,
            $options,
            $name,
            $this->storage
        );

        return $owner;
    }
}
