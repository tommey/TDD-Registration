<?php

namespace Tdd\Test\Unit;

use Tdd\SqliteStorage;

class SqliteStorageTest extends \PHPUnit_Framework_TestCase
{
	/** @var string */
	private $databaseFile;
	/** @var SqliteStorage */
	private $database;

	public function __construct()
	{
		$this->databaseFile = __DIR__ . '/test.db';
	}

	public function setUp()
	{
		if (file_exists($this->databaseFile))
		{
			throw new \ErrorException('Database file (' . $this->databaseFile . ') exists before the test.. it should not be there!');
		}

		$this->database = new SqliteStorage(array('file' => $this->databaseFile));
	}

	public function tearDown()
	{
		unset($this->database);
		unlink($this->databaseFile);
	}

	public function testStorageCanStoreAndRetrieveData()
	{
		$this->database->exec('CREATE TABLE test (id INTEGER PRIMARY KEY, data TEXT NOT NULL)');

		$this->database->query("INSERT INTO test (data) VALUES ('test')");

		$rows = $this->database->query('SELECT id, data FROM test')->fetchAll();

		$this->assertEquals(1, count($rows));

		$row = $rows[0];

		$this->assertEquals(1, $row['id']);
		$this->assertEquals('test', $row['data']);
	}

	/**
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage Sqlite configuration needs a non-empty file!
	 */
	public function testStorageThrowsExceptionForMissingConfiguration()
	{
		new SqliteStorage(array());
	}
}
