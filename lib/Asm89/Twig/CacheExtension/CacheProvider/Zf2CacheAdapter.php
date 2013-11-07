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
use Zend\Cache\Storage\StorageInterface;

/**
 * Adapter class to use the cache classes provider by Zend Framework 2.
 *
 * @author Michael Dowling <mtdowling@gmail.com>
 *
 * @link http://framework.zend.com/manual/2.0/en/modules/zend.cache.storage.adapter.html
 */
class Zf2CacheAdapter implements CacheProviderInterface
{
    private $cache;

    /**
     * @param StorageInterface $cache
     */
    public function __construct(StorageInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * {@inheritDoc}
     */
    public function fetch($key)
    {
        return $this->cache->getItem($key);
    }

    /**
     * {@inheritDoc}
     */
    public function save($key, $value, $lifetime = 0)
    {
        return $this->cache->setItem($key, $value);
    }
}
