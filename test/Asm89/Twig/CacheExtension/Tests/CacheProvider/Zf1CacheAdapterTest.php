<?php

/*
 * This file is part of twig-cache-extension.
 *
 * (c) Alexander <iam.asm89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asm89\Twig\CacheExtension\Tests\CacheProvider;

use Asm89\Twig\CacheExtension\CacheProvider\Zf1CacheAdapter;

class Zf1CacheAdapterTest extends \PHPUnit_Framework_TestCase
{
    public function testFetch()
    {
        $cache = new \Zend_Cache_Backend_Test();
        $cache = new Zf1CacheAdapter($cache);

        $this->assertEquals('foo', $cache->fetch('test'));
    }

    public function testSave()
    {
        $cache = new \Zend_Cache_Backend_Test();
        $cache = new Zf1CacheAdapter($cache);

        $cache->save('key', 'value', 42);
    }
}
