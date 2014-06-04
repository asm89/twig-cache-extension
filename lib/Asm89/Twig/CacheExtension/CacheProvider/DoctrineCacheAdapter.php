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

use Asm89\Twig\CacheExtension\CacheProviderInterface;
use Asm89\Twig\CacheExtension\Event\BlockEvent;
use Asm89\Twig\CacheExtension\Events;
use Doctrine\Common\Cache\Cache;

/**
 * Adapter class to use the cache classes provider by Doctrine.
 *
 * @author Alexander <iam.asm89@gmail.com>
 */
class DoctrineCacheAdapter extends AbstractCacheAdapter implements CacheProviderInterface
{
    private $cache;

    /**
     * @param Cache $cache
     */
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * {@inheritDoc}
     */
    public function fetch($key)
    {
        $block = $this->cache->fetch($key);

        if (null !== $this->dispatcher) {
            $this->dispatch($block !== false ? Events::BLOCK_FETCH : Events::BLOCK_MISSED, new BlockEvent($key, $block));
        }

        return $block;
    }

    /**
     * {@inheritDoc}
     */
    public function save($key, $value, $lifetime = 0)
    {
        $saved = $this->cache->save($key, $value, $lifetime);

        if (null !== $this->dispatcher) {
            $this->dispatch($saved ? Events::BLOCK_SAVE : Events::BLOCK_ERROR, new BlockEvent($key, $value));
        }

        return $saved;
    }
}
