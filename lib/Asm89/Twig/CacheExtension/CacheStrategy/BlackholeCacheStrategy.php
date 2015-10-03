<?php

/*
 * This file is part of twig-cache-extension.
 *
 * (c) Hagen Hübel <hhuebel@itinance.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asm89\Twig\CacheExtension\CacheStrategy;

use Asm89\Twig\CacheExtension\CacheStrategyInterface;

class BlackholeCacheStrategy implements CacheStrategyInterface
{

    /**
     * {@inheritDoc}
     */
    public function fetchBlock($key)
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function generateKey($annotation, $value)
    {
        return microtime(true) . mt_rand();
    }

    /**
     * {@inheritDoc}
     */
    public function saveBlock($key, $block)
    {
        // fire and forget
    }
}