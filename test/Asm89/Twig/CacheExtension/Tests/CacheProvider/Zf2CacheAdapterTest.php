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

use Asm89\Twig\CacheExtension\CacheProvider\Zf2CacheAdapter;

class Zf2CacheAdapterTest extends \PHPUnit_Framework_TestCase
{
    public function testFetch()
    {
        $cacheMock = $this->createCacheMock();
        $cacheMock->expects($this->any())
            ->method('getItem')
            ->will($this->returnValue('fromcache'));

        $cache = new Zf2CacheAdapter($cacheMock);

        $this->assertEquals('fromcache', $cache->fetch('test'));
    }

    public function testSave()
    {
        $cacheMock = $this->createCacheMock();
        $cacheMock->expects($this->once())
            ->method('setItem')
            ->with('key', 'value');

        $cache = new Zf2CacheAdapter($cacheMock);

        $cache->save('key', 'value', 42);
    }

    public function createCacheMock()
    {
        return $this->getMock('Zend\Cache\Storage\StorageInterface');
    }
}
