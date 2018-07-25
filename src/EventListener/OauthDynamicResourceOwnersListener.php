<?php

declare(strict_types=1);

namespace Contao\CoreBundle\EventListener;

use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\CoreBundle\Security\Oauth\DynamicResourceOwnerFactory;
use Contao\CoreBundle\Security\Oauth\DynamicResourceOwnerMap;
use Doctrine\DBAL\Connection;
use HWI\Bundle\OAuthBundle\Security\OAuthUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class OauthDynamicResourceOwnersListener
{
    /**
     * @var ScopeMatcher
     */
    private $scopeMatcher;
    private $connection;
    private $ownerFactory;
    private $oauthUtils;
    private $urlGenerator;

    public function __construct(
        ScopeMatcher $scopeMatcher,
        Connection $connection,
        DynamicResourceOwnerFactory $ownerFactory,
        OAuthUtils $oauthUtils,
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->scopeMatcher = $scopeMatcher;
        $this->connection = $connection;
        $this->ownerFactory = $ownerFactory;
        $this->oauthUtils = $oauthUtils;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * Sets the default locale based on the request or session.
     */
    public function onKernelRequest(GetResponseEvent $event): void
    {
        if (!$this->scopeMatcher->isContaoRequest($event->getRequest())) {
            // TODO this one does not work, somehow
            //return;
        }

        /** @var array $ownerEntries */
        $ownerEntries = $this->connection->fetchAll('SELECT * FROM tl_oauth_resource_owner');
        $owners = [];

        foreach ($ownerEntries as $ownerEntry) {
            $owner = $this->ownerFactory->create($ownerEntry['name'], $ownerEntry['type'], [
                'client_id' => $ownerEntry['application_id'],
                'client_secret' => $ownerEntry['application_secret'],
                'scope' => $ownerEntry['scope']
            ]);

            $owners[$owner->getName()] = $owner;
        }

        $map = new DynamicResourceOwnerMap($this->urlGenerator, $owners);

        $this->oauthUtils->addResourceOwnerMap($map);
    }
}
