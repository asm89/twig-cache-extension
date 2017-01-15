<?php

/*
 * This file is part of twig-cache-extension.
 *
 * (c) Alexander <iam.asm89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asm89\Twig\CacheExtension\CacheProvider;

use Asm89\Twig\CacheExtension\Event\BlockEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
abstract class AbstractCacheAdapter
{
    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * Set the event dispatcher.
     *
     * @param EventDispatcherInterface $dispatcher
     */
    public function setEventDispatcher(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Dispatches event if event dispatcher is available.
     *
     * @param string     $eventType
     * @param BlockEvent $event
     */
    protected function dispatch($eventType, BlockEvent $event)
    {
        if (null !== $this->dispatcher) {
            $this->dispatcher->dispatch($eventType, $event);
        }
    }
}
