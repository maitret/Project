<?php

require_once(ROOTDIR.'/modules/database/classes/database/result.php');
require_once(ROOTDIR.'/modules/orm/classes/orm/result.php');
require_once(TESTDIR.'/modules/orm/files/stub_orm.php');
require_once(TESTDIR.'/modules/orm/files/test_result.php');

/**
 * Generated by PHPUnit_SkeletonGenerator on 2013-02-08 at 13:27:44.
 */
class Result_ORMTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var Result_ORM
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->stub = new Test_Result;
		$this->stub->data = array(
			(object) array('id' => 1, 'name' => 'Trixie'),
			(object) array('id' => 2, 'name' => 'Tinkerbell')
		);

		$this->object = new Result_ORM('Stub_Orm', $this->stub);
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{

	}

	/**
	 * @covers Result_ORM::current
	 * @todo   Implement testCurrent().
	 */
	public function testCurrent()
	{

		$row = $this->object->current()->row;
		;
		$this->assertArrayHasKey('id', $row);
		$this->assertArrayHasKey('name', $row);
		$this->assertEquals(1, $row['id']);
		$this->assertEquals('Trixie', $row['name']);
		$this->object->next();
		$row = $this->object->current()->row;
		$this->assertArrayHasKey('id', $row);
		$this->assertArrayHasKey('name', $row);
		$this->assertEquals(2, $row['id']);
		$this->assertEquals('Tinkerbell', $row['name']);
	}

	/**
	 * @covers Result_ORM::key
	 * @todo   Implement testKey().
	 */
	public function testKey()
	{
		$this->assertEquals(0, $this->object->key());
		$this->object->next();
		$this->assertEquals(1, $this->object->key());
		$this->object->next();
		$this->assertEquals(1, $this->object->key());
	}

	public function testValid()
	{
		$this->assertEquals(true, $this->object->valid());
		$this->object->next();
		$this->assertEquals(true, $this->object->valid());
		$this->object->next();
		$this->assertEquals(false, $this->object->valid());
	}

	public function testAs_arrayArray()
	{
		$arr = $this->object->as_array(true);

		foreach (array('Trixie', 'Tinkerbell') as $key => $name)
		{
			$this->assertArrayHasKey($key, $arr);
			$row = (array) $arr[$key];
			$this->assertArrayHasKey('name', $row);
			$this->assertEquals($name, $row['name']);
		}
	}

	public function testAs_arrayObject()
	{

		$arr = $this->object->as_array();

		foreach (array('Trixie', 'Tinkerbell') as $key => $name)
		{
			$this->assertArrayHasKey($key, $arr);
			$row = $arr[$key];
			$this->assertArrayHasKey('name', $row->row);
			$this->assertEquals($name, $row->row['name']);
		}
	}

	public function test_with()
	{
		$this->stub->data = array(
			(object) array('id' => 1, 'name' => 'Trixie', 'id1' => 11, 'name1' => 'Trixie1', 'id2' => 12, 'name2' => 'Trixie2'),
			(object) array('id' => 1, 'name' => 'Tinkerbell', 'id1' => 11, 'name1' => 'Tinkerbell1', 'id2' => 12, 'name2' => 'Tinkerbell2')
		);

		$this->object = new Result_ORM('Stub_Orm', $this->stub, array(
			'tester' => array('model' => new Stub_Orm),
			'tester.another' => array('model' => new Stub_Orm)
		));
		foreach (array('Trixie', 'Tinkerbell') as $name)
		{
			$cur = $this->object->current();
			$this->assertEquals($name, $cur->row['name']);
			$this->assertArrayHasKey('tester', $cur->cached);

			$this->assertEquals($name.'1', $cur->cached['tester']->row['name']);
			$this->assertArrayHasKey('another', $cur->cached['tester']->cached);
			$this->assertEquals($name.'2', $cur->cached['tester']->cached['another']->row['name']);
			$this->object->next();
		}
	}

	public function test_withArray()
	{
		$this->stub->data = array(
			(object) array('id' => 1, 'name' => 'Trixie', 'id1' => 11, 'name1' => 'Trixie1', 'id2' => 12, 'name2' => 'Trixie2'),
			(object) array('id' => 1, 'name' => 'Tinkerbell', 'id1' => 11, 'name1' => 'Tinkerbell1', 'id2' => 12, 'name2' => 'Tinkerbell2')
		);
		$this->object = new Result_ORM('Stub_Orm', $this->stub, array(
			'tester' => array('model' => new Stub_Orm),
			'tester.another' => array('model' => new Stub_Orm)
		));
		$arr = $this->object->as_array(true);
		foreach (array('Trixie', 'Tinkerbell') as $key => $name)
		{
			$this->assertArrayHasKey($key, $arr);
			$this->assertEquals($name, $arr[$key]->name);
			$this->assertEquals($name.'1', $arr[$key]->tester->name);
			$this->assertEquals($name.'2', $arr[$key]->tester->another->name);
		}
	}

}
