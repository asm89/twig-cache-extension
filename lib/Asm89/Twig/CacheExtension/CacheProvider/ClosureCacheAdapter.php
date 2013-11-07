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
 * Adapter class to use the closures.
 *
 * @author Michael Dowling <mtdowling@gmail.com>
 */
class ClosureCacheAdapter implements CacheProviderInterface
{
    private $callable;

    /**
     * The array of callable is an mapping of the actions:
     * - fetch: Callable that accepts an $id and $options argument
     * - save:  Callable that accepts an $id, $data, $lifetime
     *
     * @param array $callable array of action names to callable
     *
     * @throws \InvalidArgumentException if the given value is not callable
     */
    public function __construct(array $callable)
    {
        if (!isset($callable['fetch']) || !is_callable($callable['fetch'])) {
            throw new \InvalidArgumentException('$callable must contain a callable "fetch" key');
        }

        if (!isset($callable['save']) || !is_callable($callable['save'])) {
            throw new \InvalidArgumentException('$callable must contain a callable "save" key');
        }

        $this->callable = $callable;
    }

    /**
     * {@inheritDoc}
     */
    public function fetch($key)
    {
        return call_user_func($this->callable['fetch'], $key);
    }

    /**
     * {@inheritDoc}
     */
    public function save($key, $value, $lifetime = 0)
    {
        return call_user_func($this->callable['save'], $key, $value, $lifetime);
    }
}
