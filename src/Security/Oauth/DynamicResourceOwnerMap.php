<?php

declare(strict_types=1);

namespace Contao\CoreBundle\Security\Oauth;

use Doctrine\DBAL\Connection;
use HWI\Bundle\OAuthBundle\OAuth\ResourceOwnerInterface;
use HWI\Bundle\OAuthBundle\Security\Http\ResourceOwnerMapInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DynamicResourceOwnerMap implements ResourceOwnerMapInterface
{
    protected $resourceOwners;
    protected $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator, array $resourceOwners)
    {
        $this->resourceOwners = $resourceOwners;
        $this->urlGenerator = $urlGenerator;
    }

    public function hasResourceOwnerByName($name)
    {
    }

    public function getResourceOwnerByName($name)
    {
        if (!array_key_exists($name, $this->resourceOwners)) {
            return null;
        }

        return $this->resourceOwners[$name];
    }

    public function getResourceOwnerByRequest(Request $request)
    {
        die("getResourceOwnerByRequest");
    }

    public function getResourceOwnerCheckPath($name)
    {
        return $this->urlGenerator->generate('oauth_dynamic_login', [
            'owner' => $name,
        ]);
    }

    public function getResourceOwners()
    {
        $owners = [];

        /** @var ResourceOwnerInterface $resourceOwner */
        foreach ($this->resourceOwners as $resourceOwner) {
            $owners[$resourceOwner->getName()] = $this->getResourceOwnerCheckPath($resourceOwner->getName());
        }

        return $owners;
    }
}
