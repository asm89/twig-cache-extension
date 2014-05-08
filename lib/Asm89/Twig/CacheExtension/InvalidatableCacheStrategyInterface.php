<?php

/*
 * This file is part of twig-cache-extension.
 *
 * (c) Alexander <iam.asm89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asm89\Twig\CacheExtension;

/**
 * Invalidatable cache strategy interface.
 *
 * @author Teoh Han Hui <teohhanhui@gmail.com>
 */
interface InvalidatableCacheStrategyInterface
{
    /**
     * Invalidate the block for a given key.
     *
     * @param mixed $key
     */
    public function invalidateBlock($key);
}
