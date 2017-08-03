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

/**
 * Adapter class to make the Asm89 Twig caching extension interoperable with every PSR-16 adapter.
 *
 * @see http://www.php-fig.org/psr/psr-16/
 *
 * @author Heino H. Gehlsen <heino@gehlsen.dk>
 * @copyright 2017 Heino H. Gehlsen
 * @license MIT
 */
class PsrSimpleCacheAdapter
	implements \Asm89\Twig\CacheExtension\CacheProviderInterface
{
    /**
     * @var \Psr\SimpleCache\CacheInterface
     */
    private $cache;

    /**
     * @param \Psr\SimpleCache\CacheInterface $cache
     */
    public function __construct(\Psr\SimpleCache\CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param string $key
     * @return mixed|false
     */
    public function fetch($key)
    {
		return $this->cache->get($key);
	}

    /**
     * @param string $key
     * @param string $value
     * @param int|\DateInterval $lifetime
     * @return bool
     */
    public function save($key, $value, $lifetime = 0)
    {
		return $this->cache->set($key, $value, $lifetime);
    }
}
