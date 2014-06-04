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

/**
 * Block event class.
 *
 * @author Teoh Han Hui <teohhanhui@gmail.com>
 */
class BlockEvent extends Event
{
    private $key;
    private $block;

    /**
     * Constructor.
     *
     * @param string $key
     * @param mixed  $block
     */
    public function __construct($key, $block)
    {
        $this->key   = $key;
        $this->block = $block;
    }

    /**
     * Get key.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Get block.
     *
     * @return mixed
     */
    public function getBlock()
    {
        return $this->block;
    }
}
