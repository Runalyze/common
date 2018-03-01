<?php

/*
 * This file is part of the Runalyze Common.
 *
 * (c) RUNALYZE <mail@runalyze.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Runalyze\Common\Tests\LazyFilesystemObject;

use Runalyze\Common\LazyFilesystemObject\DefaultHashToPathMapper;

class DefaultHashToPathMapperTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultMapper()
    {
        $mapper = new DefaultHashToPathMapper(3, 2, '/');

        $this->assertEquals('ab/cd/ef/abcdef0987654321', $mapper->hashToPath('abcdef0987654321'));
        $this->assertEquals('abcdef0987654321', $mapper->pathToHash('ab/cd/ef/abcdef0987654321'));
    }

    public function testOtherSeparator()
    {
        $mapper = new DefaultHashToPathMapper(3, 2, '/_');

        $this->assertEquals('ab/_cd/_ef/_abcdef0987654321', $mapper->hashToPath('abcdef0987654321'));
        $this->assertEquals('abcdef0987654321', $mapper->pathToHash('ab/_cd/_ef/_abcdef0987654321'));
    }

    public function testOtherDirectorySize()
    {
        $mapper = new DefaultHashToPathMapper(2, 3, '/');

        $this->assertEquals('abc/def/abcdef0987654321', $mapper->hashToPath('abcdef0987654321'));
        $this->assertEquals('abcdef0987654321', $mapper->pathToHash('abc/def/abcdef0987654321'));
    }
}
