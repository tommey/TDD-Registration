<?php

namespace Tdd\Database;

class SqliteStorage extends PersistentStorage
{
	/** @var string */
	private $databaseFile;

	/**
	 * @param array $configuration
	 */
	public function __construct(array $configuration)
	{
		if (empty($configuration['file']))
		{
			throw new \InvalidArgumentException('Sqlite configuration needs a non-empty file!');
		}

		parent::__construct('sqlite:' . ($this->databaseFile = $configuration['file']));
	}
}
