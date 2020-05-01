<?php

namespace AndreasGlaser\Helpers\Tests\Traits;

use AndreasGlaser\Helpers\Tests\BaseTest;
use AndreasGlaser\Helpers\Traits\RuntimeCacheTrait;

/**
 * Class RuntimeCacheTraitTest.
 */
class RuntimeCacheTraitTest extends BaseTest
{
    public function test()
    {
        $class = new RuntimeCacheTest();

        self::assertTrue(\method_exists($class, 'rtcSet'));
        self::assertTrue(\method_exists($class, 'rtcExists'));
        self::assertTrue(\method_exists($class, 'rtcGet'));
        self::assertTrue(\method_exists($class, 'rtcGetDelete'));
        self::assertTrue(\method_exists($class, 'rtcDelete'));
        self::assertTrue(\method_exists($class, 'rtcGroupGet'));
        self::assertTrue(\method_exists($class, 'rtcGroupDelete'));
        self::assertTrue(\method_exists($class, 'rtcGroupAdd'));
        self::assertTrue(\method_exists($class, 'rtcGroupExists'));
        self::assertTrue(\method_exists($class, 'rtcMakeId'));

        $id = $class->rtcMakeId('a', [1 => 2], new \stdClass(), 123);
        $group = 'MyGroup';
        $data = ['Something'];

        self::assertEquals($id, $class->rtcMakeId('a', [1 => 2], new \stdClass(), 123));
        self::assertNotEquals($id, $class->rtcMakeId('b', [1 => 2], new \stdClass(), 123));
        self::assertInstanceOf('AndreasGlaser\Helpers\Tests\Traits\RuntimeCacheTest', $class->rtcSet($data, $id, $group, true));
        self::assertTrue($class->rtcGroupExists($group));
        self::assertTrue($class->rtcExists($id, $group));
        self::assertFalse($class->rtcExists('wong-id', $group));
        self::assertFalse($class->rtcExists($id, 'wrong-group'));
        self::assertInstanceOf('AndreasGlaser\Helpers\Tests\Traits\RuntimeCacheTest', $class->rtcSet('ABC', $id, $group, false));
        self::assertEquals($data, $class->rtcGet($id, $group));
        self::assertEquals('MYDEFAULT', $class->rtcGet($id, 'wrong-group', 'MYDEFAULT'));
        self::assertFalse($class->rtcGroupExists('wrong-group'));
        self::assertEquals([$id => $data], $class->rtcGroupGet($group));
        self::assertEquals([], $class->rtcGroupGet('wrong-group', []));
        self::assertFalse($class->rtcGetDelete('wrong-id', $group, false));
        self::assertFalse($class->rtcGetDelete($id, 'wrong-group', false));
        self::assertEquals($data, $class->rtcGetDelete($id, $group));
        self::assertFalse($class->rtcExists($id, $group));
        self::assertTrue($class->rtcGroupExists($group));
        self::assertInstanceOf('AndreasGlaser\Helpers\Tests\Traits\RuntimeCacheTest', $class->rtcGroupDelete($group));
        self::assertFalse($class->rtcGroupExists($group));
    }
}

class RuntimeCacheTest
{
    use  RuntimeCacheTrait;
}
