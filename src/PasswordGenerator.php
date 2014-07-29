<?php

namespace Tdd;

class PasswordGenerator
{
	private $minimumLength;
	private $maximumLength;
	private $characterSet;

	public function __construct($minimumLength, $maximumLength, $characterSet)
	{
		$this->minimumLength = $minimumLength;
		$this->maximumLength = $maximumLength;
		$this->characterSet = $characterSet;
	}

	public function generate()
	{
		return substr(
			str_shuffle(str_repeat($this->characterSet, 1 + floor($this->maximumLength / strlen($this->characterSet)))),
			0,
			rand($this->minimumLength, $this->maximumLength)
		);
	}
}
