<?php

namespace AndreasGlaser\Helpers\Tests\Traits;

use AndreasGlaser\Helpers\Tests\BaseTest;
use AndreasGlaser\Helpers\Traits\RuntimeCacheTrait;

/**
 * Class RuntimeCacheTraitTest
 *
 * @package AndreasGlaser\Helpers\Tests\Traits
 * @author  Andreas Glaser
 */
class RuntimeCacheTraitTest extends BaseTest
{
    public function test()
    {
        $class = new RuntimeCacheTest();

        $this->assertTrue(method_exists($class, 'rtcSet'));
        $this->assertTrue(method_exists($class, 'rtcExists'));
        $this->assertTrue(method_exists($class, 'rtcGet'));
        $this->assertTrue(method_exists($class, 'rtcGetDelete'));
        $this->assertTrue(method_exists($class, 'rtcDelete'));
        $this->assertTrue(method_exists($class, 'rtcGroupGet'));
        $this->assertTrue(method_exists($class, 'rtcGroupDelete'));
        $this->assertTrue(method_exists($class, 'rtcGroupAdd'));
        $this->assertTrue(method_exists($class, 'rtcGroupExists'));
        $this->assertTrue(method_exists($class, 'rtcMakeId'));

        $id = $class->rtcMakeId('a', [1 => 2], new \stdClass(), 123);
        $group = 'MyGroup';
        $data = ['Something'];

        $this->assertEquals($id, $class->rtcMakeId('a', [1 => 2], new \stdClass(), 123));
        $this->assertNotEquals($id, $class->rtcMakeId('b', [1 => 2], new \stdClass(), 123));
        $this->assertInstanceOf('AndreasGlaser\Helpers\Tests\Traits\RuntimeCacheTest', $class->rtcSet($data, $id, $group, true));
        $this->assertTrue($class->rtcGroupExists($group));
        $this->assertTrue($class->rtcExists($id, $group));
        $this->assertFalse($class->rtcExists('wong-id', $group));
        $this->assertFalse($class->rtcExists($id, 'wrong-group'));
        $this->assertInstanceOf('AndreasGlaser\Helpers\Tests\Traits\RuntimeCacheTest', $class->rtcSet('ABC', $id, $group, false));
        $this->assertEquals($data, $class->rtcGet($id, $group));
        $this->assertEquals('MYDEFAULT', $class->rtcGet($id, 'wrong-group', 'MYDEFAULT'));
        $this->assertFalse($class->rtcGroupExists('wrong-group'));
        $this->assertEquals([$id => $data], $class->rtcGroupGet($group));
        $this->assertEquals([], $class->rtcGroupGet('wrong-group', []));
        $this->assertFalse($class->rtcGetDelete('wrong-id', $group, false));
        $this->assertFalse($class->rtcGetDelete($id, 'wrong-group', false));
        $this->assertEquals($data, $class->rtcGetDelete($id, $group));
        $this->assertFalse($class->rtcExists($id, $group));
        $this->assertTrue($class->rtcGroupExists($group));
        $this->assertInstanceOf('AndreasGlaser\Helpers\Tests\Traits\RuntimeCacheTest', $class->rtcGroupDelete($group));
        $this->assertFalse($class->rtcGroupExists($group));
    }
}

class RuntimeCacheTest
{
    use  RuntimeCacheTrait;
}