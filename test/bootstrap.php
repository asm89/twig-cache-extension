<?php

/*
 * This file is part of twig-cache-extension.
 *
 * (c) Alexander <iam.asm89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (file_exists($file = __DIR__.'/../vendor/autoload.php')) {
    $autoload = require_once $file;
} else {
    throw new RuntimeException('Install dependencies to run test suite.');
}

// Modify the include path so that it can find the Zend Framework
$paths = array('vendor/zend/zend-cache1', 'vendor/zend/zend-log1');
set_include_path(implode(PATH_SEPARATOR, array_map(function($path) {
    return __DIR__ . '/../' . $path;
}, $paths)) . PATH_SEPARATOR . get_include_path());
