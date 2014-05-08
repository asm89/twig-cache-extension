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
 * Invalidatable cache provider interface.
 *
 * @author Teoh Han Hui <teohhanhui@gmail.com>
 */
interface InvalidatableCacheProviderInterface
{
    /**
     * @param string $key
     */
    public function invalidate($key);
}
