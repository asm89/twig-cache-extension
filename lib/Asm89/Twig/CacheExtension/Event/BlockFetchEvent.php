<?php

/*
 * This file is part of twig-cache-extension.
 *
 * (c) Alexander <iam.asm89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asm89\Twig\CacheExtension\Event;

use Symfony\Component\EventDispatcher\Event;

class BlockFetchEvent extends Event
{
    private $key;
    private $block;

    /**
     * @param string $key
     * @param string $block
     */
    public function __construct($key, $block)
    {
        $this->key = $key;
        $this->block = $block;
    }

    /**
     * Get key.
     *
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Get block.
     *
     * @return string
     */
    public function getBlock()
    {
        return $this->block;
    }
}
