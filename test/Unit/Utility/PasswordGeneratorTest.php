<?php

namespace Tdd\Test\Unit\Utility;

use Tdd\Utility\PasswordGenerator;

class PasswordGeneratorTest extends \PHPUnit_Framework_TestCase
{
	public function intervalDataProvider()
	{
		return array(
			array(1, 1, 'a'),
			array(1, 10, 'abc'),
			array(5, 50, 'abcdfgleoerjkljdnfldkynmaodfnsodf'),
			array(500, 4000, 'lseknjfgksdjnfopiajwrgtiusnewpofjgdilfjn'),
		);
	}

	/**
	 * @dataProvider intervalDataProvider
	 *
	 * @param int    $minimumLength
	 * @param int    $maximumLength
	 * @param string $characterSet
	 */
	public function testPasswordGeneratorCanGenerateValidPassword($minimumLength, $maximumLength, $characterSet)
	{
		$passwordGenerator = new PasswordGenerator($minimumLength, $maximumLength, $characterSet);

		$generatedPassword = $passwordGenerator->generate();
		$generatedPasswordLength = strlen($generatedPassword);

		$this->assertGreaterThanOrEqual($minimumLength, $generatedPasswordLength);
		$this->assertLessThanOrEqual($maximumLength, $generatedPasswordLength);
		$this->assertRegExp('/^[' . $characterSet . ']{' . $minimumLength . ',' . $maximumLength . '}$/', $generatedPassword);
	}
}
