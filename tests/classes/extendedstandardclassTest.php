<?php
require_once dirname( dirname( dirname( __FILE__ ) ) ) . '\classes\extendedstandardclass.php';

class Dummy_ESC extends ExtendedStandardClass {}

/**
 * Test class for ExtendedStandardClass
 */
class ExtendedStandardClassTest extends \WP_UnitTestCase
{
	/**
	 * @var ExtendedStandardClass
	 */
	protected $object;

	/**
	 * ID for tests
	 * @var string
	 */
	protected $id = 'foobarbaz';

    /**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	public function setUp() {
		$this->object = new Dummy_ESC();
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	public function tearDown() {}

	/**
	 * @covers ExtendedStandardClass::set_id()
	 */
	public function testSet_id() {

		$this->object->set_id( $this->id );

		$result = ( Dummy_ESC::$id === $this->id );

		$this->assertTrue( $result );

	}

	/**
	 * @covers ExtendedStandardClass::__set()
	 */
	public function testSet() {

		$bar = 'bar';
		$baz = 'foo';
		$var = 'baz';
		$id  = $this->id;

		$this->object->set_id( $id );

		// set some data with __set()
		$this->object->bar  = $var;
		$this->object->$baz = 'foo';

		// test first if the data storage exists
		$datastorage = Dummy_ESC::$data;
		$this->assertTrue( isset( $datastorage ) );

		// test if the data was stored with the given id
		$this->assertTrue( property_exists( $datastorage->$id, 'bar' ) );
		$this->assertTrue( property_exists( $datastorage->$id, $baz ) );

	}

	/**
	 * @covers ExtendedStandardClass::__get()
	 */
	public function testGet() {

		$bar = 'bar';
		$baz = 'foo';
		$var = 'baz';
		$id  = $this->id;

		$this->object->set_id( $id );

		$this->object->bar = $var;
		$result = ( $this->object->bar === $var );

		$this->assertTrue( $result );

		$this->object->$baz = $var;
		$result = ( $this->object->$baz === $var );

		$this->assertTrue( $result );

	}

	/**
	 * @covers ExtendedStandardClass::__isset()
	 */
	public function testIsset() {

		$bar = 'bar';
		$baz = 'foo';
		$var = 'baz';
		$id  = $this->id;

		$this->object->set_id( $id );

		$this->object->bar = $var;
		$this->assertTrue( isset( $this->object->bar ) );

		$this->object->$baz = $var;
		$this->assertTrue( isset( $this->object->$baz ) );

	}

	/**
	 * @covers ExtendedStandardClass::getIterator()
	 */
	public function testGetIterator() {

		$result = ( is_array( $this->object ) || $this->object instanceof Traversable );
		$this->assertTrue( $result );

	}

	/**
	 * @covers ExtendedStandardClass::getIterator()
	 */
	public function testGetIterator_direkt() {

		$arr = $this->object->getIterator();

		$result = ( is_array( $arr ) || $arr instanceof Traversable );
		$this->assertTrue( $result );

	}

	/**
	 * @covers ExtendedStandardClass::print_error()
	 */
	public function testPrint_error_indirekt() {

		Dummy_ESC::$show_errors = true;

		$this->setExpectedException( 'PHPUnit_Framework_Error_Notice' );
		$this->assertFalse( $this->object->set_id( '' ) );
		$this->assertFalse( $this->object->bar );

	}

	/**
	 * @covers ExtendedStandardClass::print_error()
	 */
	public function testPrint_error_direkt() {

		Dummy_ESC::$show_errors = false;

		$this->assertFalse( $this->object->print_error( 'no id', __METHOD__ ) );

	}

}