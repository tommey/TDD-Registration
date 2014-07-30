<?php

namespace Tdd;

class SqliteStorage extends PersistentStorage
{
	private $databaseFile;

	public function __construct(array $configuration)
	{
		if (empty($configuration['file']))
		{
			throw new \InvalidArgumentException('Sqlite configuration needs a non-empty file!');
		}

		parent::__construct('sqlite:' . ($this->databaseFile = $configuration['file']));
	}
}
