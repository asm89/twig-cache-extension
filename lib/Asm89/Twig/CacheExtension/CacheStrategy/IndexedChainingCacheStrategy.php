<?php

/*
 * This file is part of twig-cache-extension.
 *
 * (c) Alexander <iam.asm89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asm89\Twig\CacheExtension\CacheStrategy;

use Asm89\Twig\CacheExtension\CacheStrategyInterface;
use Asm89\Twig\CacheExtension\Event\BlockFetchEvent;
use Asm89\Twig\CacheExtension\Event\BlockSaveEvent;
use Asm89\Twig\CacheExtension\Events;
use Asm89\Twig\CacheExtension\InvalidatableCacheStrategyInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Combines several configured cache strategies.
 *
 * Useful for combining for example generational cache strategy with a lifetime
 * cache strategy, but also useful when combining several generational cache
 * strategies which differ on cache lifetime (infinite, 1hr, 5m).
 *
 * @author Alexander <iam.asm89@gmail.com>
 */
class IndexedChainingCacheStrategy implements CacheStrategyInterface, InvalidatableCacheStrategyInterface
{
    private $strategies;
    private $dispatcher;

    /**
     * @param array $strategies
     */
    public function __construct(array $strategies)
    {
        $this->strategies = $strategies;
    }

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
     * {@inheritDoc}
     */
    public function fetchBlock($key)
    {
        $block = $this->strategies[$key['strategyKey']]->fetchBlock($key['key']);

        if ($this->dispatcher && $block !== false) {
            $this->dispatcher->dispatch(Events::BLOCK_FETCH, new BlockFetchEvent($key['key'], $block));
        }

        return $block;
    }

    /**
     * {@inheritDoc}
     */
    public function generateKey($annotation, $value)
    {
        if (! is_array($value) || null === $strategyKey = key($value)) {
            //todo: specialized exception
            throw new \RuntimeException('No strategy key found in value.');
        }

        if (! isset($this->strategies[$strategyKey])) {
            //todo: specialized exception
            throw new \RuntimeException(sprintf('No strategy configured with key "%s".', $strategyKey));
        }

        $key = $this->strategies[$strategyKey]->generateKey($annotation, current($value));

        return array(
            'strategyKey' => $strategyKey,
            'key' => $key,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function saveBlock($key, $block)
    {
        $saved = $this->strategies[$key['strategyKey']]->saveBlock($key['key'], $block);

        if ($this->dispatcher && $saved) {
            $this->dispatcher->dispatch(Events::BLOCK_SAVE, new BlockSaveEvent($key['key'], $block));
        }

        return $saved;
    }

    /**
     * {@inheritDoc}
     */
    public function invalidateBlock($key)
    {
        return $this->strategies[$key['strategyKey']]->invalidateBlock($key['key']);
    }
}
