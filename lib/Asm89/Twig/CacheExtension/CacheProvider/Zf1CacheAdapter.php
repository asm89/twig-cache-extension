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

/**
 * Adapter class to use the cache classes provider by Zend Framework 1.
 *
 * @author Michael Dowling <mtdowling@gmail.com>
 */
class Zf1CacheAdapter implements CacheProviderInterface
{
    private $cache;

    /**
     * @param \Zend_Cache_Backend $cache
     */
    public function __construct(\Zend_Cache_Backend $cache)
    {
        $this->cache = $cache;
    }

    /**
     * {@inheritDoc}
     */
    public function fetch($key)
    {
        return $this->cache->load($key);
    }

    /**
     * {@inheritDoc}
     */
    public function save($key, $value, $lifetime = 0)
    {
        return $this->cache->save($value, $key, array(), $lifetime);
    }
}
