<?php

namespace Tdd\Test;

use Tdd\PasswordGenerator;

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
	 * @param $minimumLength
	 * @param $maximumLength
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
