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

use Asm89\Twig\CacheExtension\CacheProvider\ClosureCacheAdapter;

class ClosureCacheAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getInvalidClosures
     * @expectedException \InvalidArgumentException
     */
    public function testInvalid($closure)
    {
        $test = new ClosureCacheAdapter($closure);
    }

    public function testFetch()
    {
        $cache = new ClosureCacheAdapter($this->createCacheMock());

        $this->assertEquals('fromcache', $cache->fetch('test'));
    }

    public function testSave()
    {
        $cache = new ClosureCacheAdapter($this->createCacheMock());

        $this->assertEquals('saved', $cache->save('key', 'value', 42));
    }

    public function createCacheMock()
    {
        return array(
            'fetch' => function($key) {
                return 'fromcache';
            },
            'save'  => function($key, $value, $lifetime) {
                return 'saved';
            }
        );
    }

    public function getInvalidClosures()
    {
        return array(
            array(array()),
            array(
                array('fetch' => null)
            ),
            array(
                array('fetch' => 'test'),
            ),
            array(
                array('save' => null)
            ),
            array(
                array('fetch' => null),
                array('save' => null)
            ),
            array(
                array('fetch' => function() {}),
                array('save' => 'test')
            ),
        );
    }
}
