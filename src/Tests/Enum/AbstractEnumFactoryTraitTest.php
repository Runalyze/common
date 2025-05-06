<?php

/*
 * This file is part of Runalyze Common.
 *
 * (c) RUNALYZE <mail@runalyze.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Runalyze\Common\Enum;

class AbstractEnumFactoryTrait_MockTester extends AbstractEnum
{
    use AbstractEnumFactoryTrait;

    const FOO = 'foo';
    const FOO_BAR = 'bar';

    public static function getEnum(): array
    {
        return [
            'FOO' => 'foo',
            'FOO_BAR' => 'bar'
        ];
    }
}

class Foo extends AbstractEnum
{
}
class FooBar extends AbstractEnum
{
}

class AbstractEnumFactoryTrait_WrongMockTester
{
    use AbstractEnumFactoryTrait;

    const TEST = 0;

    public static function getEnum(): array
    {
        return [
            'TEST' => 0
        ];
    }
}

class AbstractEnumFactoryTraitTest extends \PHPUnit\Framework\TestCase
{
    public function testFoo()
    {
        $object = AbstractEnumFactoryTrait_MockTester::get(AbstractEnumFactoryTrait_MockTester::FOO);

        $this->assertTrue($object instanceof Foo);
    }

    public function testFooBar()
    {
        $object = AbstractEnumFactoryTrait_MockTester::get(AbstractEnumFactoryTrait_MockTester::FOO_BAR);

        $this->assertTrue($object instanceof FooBar);
    }

    public function testInvalidEnum()
    {
        $this->expectException(\InvalidArgumentException::class);

        AbstractEnumFactoryTrait_MockTester::get('idontexist');
    }

    public function testInvalidClass()
    {
        $this->expectException(\Error::class);

        AbstractEnumFactoryTrait_WrongMockTester::get(AbstractEnumFactoryTrait_WrongMockTester::TEST);
    }
}
