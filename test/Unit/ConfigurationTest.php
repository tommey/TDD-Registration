<?php

namespace Tdd\Test\Unit;

use Tdd\Configuration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
	/** @var  Configuration */
	private $configuration;

	public function setUp()
	{
		$this->configuration = new Configuration();
	}

	public function testConfigurationCanStoreAndRetrieveValueByKey()
	{
		$key = 'key';
		$value = 'value';

		$this->configuration->set($key, $value);

		$this->assertEquals($value, $this->configuration->get($key));
	}

	/**
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage Key must be a non-empty string!
	 */
	public function testConfigurationThrowsExceptionForNonStringKey()
	{
		$this->configuration->set(0, 0);
	}
}
