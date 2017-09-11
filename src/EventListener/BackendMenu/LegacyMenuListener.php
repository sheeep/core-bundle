<?php

namespace Contao\CoreBundle\EventListener\BackendMenu;

use Contao\CoreBundle\Event\BackendMenuEvent;
use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class LegacyMenuListener
{
    private $factory;
    private $tokenStorage;

    public function __construct(FactoryInterface $factory, TokenStorageInterface $tokenStorage)
    {
        $this->factory = $factory;
        $this->tokenStorage = $tokenStorage;
    }

    public function onBuild(BackendMenuEvent $event)
    {
        $tree = $event->getTree();

        $user = $this->tokenStorage->getToken()->getUser();
        $modules = $user->navigation();

        foreach ($modules as $category => $categoryOptions) {

            // Create a category node if it doesn't exist yet
            if (!$tree->getChild($category)) {
                $node = $this->factory->createItem($category, [
                    'label' => $categoryOptions['label'],
                    'attributes' => [
                        'title' => $categoryOptions['title'],
                        'trail' => false,
                        'href' => $categoryOptions['href']
                    ]
                ]);

                $node->setDisplayChildren(strpos($categoryOptions['class'], 'node-expanded') !== false);

                $tree->addChild($node);
            }

            // Create the child nodes
            foreach ($categoryOptions['modules'] as $nodeName => $nodeOptions) {
                $node = $this->factory->createItem($nodeName, [
                    'label' => $nodeOptions['label'],
                    'attributes' => [
                        'title' => $nodeOptions['title'],
                        'class' => $nodeName,
                        'trail' => false,
                        'href' => $nodeOptions['href']
                    ]
                ]);

                $node->setCurrent($nodeOptions['isActive']);

                $tree->getChild($category)->addChild($node);
            }
        }

        return $tree;
    }
}