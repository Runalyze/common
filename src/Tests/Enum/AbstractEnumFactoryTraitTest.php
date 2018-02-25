<?php

/*
 * This file is part of the Runalyze Common.
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
}

class AbstractEnumFactoryTraitTest extends \PHPUnit_Framework_TestCase
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

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidEnum()
    {
        AbstractEnumFactoryTrait_MockTester::get('idontexist');
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testInvalidClass()
    {
        AbstractEnumFactoryTrait_WrongMockTester::get(AbstractEnumFactoryTrait_WrongMockTester::TEST);
    }
}
