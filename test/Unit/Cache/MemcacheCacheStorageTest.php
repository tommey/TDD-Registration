<?php

namespace Tdd\Test\Unit\Cache;

use Tdd\Cache\MemcacheCacheStorage;

class MemcacheCacheStorageTest extends \PHPUnit_Framework_TestCase
{
	public function dataProvider()
	{
		return array(
			array('key', 'value'),
			array('key', 'value2'),
			array('key', 1234),
			array('key', 3.14),
			array('key', array('test', 12, 3.1415)),
			array('key', (object)array('test' => 12, 'float' => 3.1415))
		);
	}

	/**
	 * @dataProvider dataProvider
	 *
	 * @param string $key
	 * @param mixed $value
	 */
	public function testMemcacheCacheStorageCanStoreAndRetrieveData($key, $value)
	{
		/** @var \Memcache|\PHPUnit_Framework_MockObject_MockObject $memcache */
		$memcache = $this->getMock('\\Memcache', array('set', 'get'));
		$memcache->expects($this->once())->method('set')->with($key, $value, 0, 0)->willReturn(true);
		$memcache->expects($this->once())->method('get')->with($key)->willReturn($value);

		$storage = new MemcacheCacheStorage($memcache);

		$this->assertSame($value, $storage->get($key));
		$this->assertTrue($storage->set($key, $value));
	}
}
