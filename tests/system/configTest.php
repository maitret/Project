<?php

require_once(TESTDIR.'/system/mocks/misc.php');
require_once(ROOTDIR.'/system/classes/config.php');

/**
 * Generated by PHPUnit_SkeletonGenerator on 2013-02-06 at 09:17:25.
 */
class configTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var Config
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		Misc::$file = (dirname(__FILE__).'/files/config.php');
		file_put_contents(Misc::$file, "<?php return ".var_export(array(
				'trees' => array(
					'oak' => array(
						'fairy' => 'Tinkerbell'
					)
				)
				), true).';');
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{

	}

	/**
	 * @covers Config::get_group
	 * @todo   Implement testGet_group().
	 */
	public function testGet_group()
	{
		$group = Config::get_group('test');
		$this->assertArrayHasKey('trees', $group);
		$this->assertArrayHasKey('oak', $group['trees']);
		$this->assertArrayHasKey('fairy', $group['trees']['oak']);
		$this->assertEquals($group['trees']['oak']['fairy'], 'Tinkerbell');
	}

	/**
	 * @covers Config::get
	 * @todo   Implement testGet().
	 */
	public function testGet()
	{
		$this->assertEquals(Config::get('test.trees.oak.fairy'), 'Tinkerbell');
		$this->assertEquals(Config::get('test.trees.oak.fairies', 'default'), 'default');
	}

	/**
	 * @covers Config::set
	 * @todo   Implement testSet().
	 */
	public function testSet()
	{
		Config::set('test.trees.oak.second_fairy', 'Trixie');
		$this->assertEquals(Config::get('test.trees.oak.second_fairy'), 'Trixie');
	}

	/**
	 * @covers Config::write
	 * @todo   Implement testWrite().
	 */
	public function testWrite()
	{
		Config::set('test.trees.oak.second_fairy', 'Trixie');
		Config::write('test');
		$group = include(Misc::$file);
		$this->assertArrayHasKey('trees', $group);
		$this->assertArrayHasKey('oak', $group['trees']);
		$this->assertArrayHasKey('second_fairy', $group['trees']['oak']);
		$this->assertEquals($group['trees']['oak']['second_fairy'], 'Trixie');
	}

}
