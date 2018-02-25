<?php

/*
 * This file is part of the Runalyze Common.
 *
 * (c) RUNALYZE <mail@runalyze.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Runalyze\Common\Tests\BsonSerializable;

use Runalyze\Common\BsonSerializable\AbstractBsonSerializableObject;

class AbstractBsonSerializableObjectTest extends \PHPUnit_Framework_TestCase
{
    public function testSimpleMethods()
    {
        /** @var AbstractBsonSerializableObject $mock */
        $mock = $this->getMockForAbstractClass(AbstractBsonSerializableObject::class);

        $this->assertFalse($mock->isDirty());
        $this->assertNull($mock->getHash());

        $mock->setHash('foobar');
        $this->assertEquals('foobar', $mock->getHash());
    }

    public function testSimpleBinaryConversionAndBack()
    {
        $mock = new FakeFooBarObject();

        /** @var FakeFooBarObject $mock */
        $mock = $mock->fromBinary($mock->toBinary());

        $this->assertNull($mock->Foo);
        $this->assertNull($mock->Bar);

        $mock->Foo = '42';
        $mock->Bar = [1, 2, 3];

        $mock = $mock->fromBinary($mock->toBinary());

        $this->assertEquals('42', $mock->Foo);
        $this->assertEquals([1, 2, 3], $mock->Bar);
    }
}
