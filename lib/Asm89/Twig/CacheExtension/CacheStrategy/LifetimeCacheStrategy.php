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

use Asm89\Twig\CacheExtension\CacheProviderInterface;
use Asm89\Twig\CacheExtension\CacheStrategyInterface;
use Asm89\Twig\CacheExtension\Event\BlockFetchEvent;
use Asm89\Twig\CacheExtension\Event\BlockSaveEvent;
use Asm89\Twig\CacheExtension\Events;
use Asm89\Twig\CacheExtension\InvalidatableCacheStrategyInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Strategy for caching with a pre-defined lifetime.
 *
 * The value passed to the strategy is the lifetime of the cache block in
 * seconds.
 *
 * @author Alexander <iam.asm89@gmail.com>
 */
class LifetimeCacheStrategy implements CacheStrategyInterface, InvalidatableCacheStrategyInterface
{
    private $cache;
    private $dispatcher;

    /**
     * @param CacheProviderInterface $cache
     */
    public function __construct(CacheProviderInterface $cache)
    {
        $this->cache = $cache;
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
        $block = $this->cache->fetch($key['key']);

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
        if (! is_numeric($value)) {
            //todo: specialized exception
            throw new \RuntimeException('Value is not a valid lifetime.');
        }

        return array(
            'lifetime' => $value,
            'key' => '__LCS__' . $annotation,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function saveBlock($key, $block)
    {
        $saved = $this->cache->save($key['key'], $block, $key['lifetime']);

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
        return $this->cache->invalidate($key['key']);
    }
}
