<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2017
 */


namespace Aimeos\Controller\Common\Catalog\Import\Csv\Processor\Text;


class StandardTest extends \PHPUnit\Framework\TestCase
{
	private $context;
	private $endpoint;


	protected function setUp()
	{
		\Aimeos\MShop\Factory::setCache( true );

		$this->context = \TestHelperCntl::getContext();
		$this->endpoint = new \Aimeos\Controller\Common\Catalog\Import\Csv\Processor\Done( $this->context, [] );
	}


	protected function tearDown()
	{
		\Aimeos\MShop\Factory::setCache( false );
		\Aimeos\MShop\Factory::clear();
	}


	public function testProcess()
	{
		$mapping = array(
			0 => 'text.type',
			1 => 'text.content',
			2 => 'text.label',
			3 => 'text.languageid',
			4 => 'text.status',
		);

		$data = array(
			0 => 'name',
			1 => 'Job CSV test',
			2 => 'test text',
			3 => 'de',
			4 => 1,
		);

		$catalog = $this->create( 'job_csv_test' );

		$object = new \Aimeos\Controller\Common\Catalog\Import\Csv\Processor\Text\Standard( $this->context, $mapping, $this->endpoint );
		$object->process( $catalog, $data );

		$catalog = $this->get( 'job_csv_test' );
		$this->delete( $catalog );


		$listItems = $catalog->getListItems();
		$listItem = reset( $listItems );

		$this->assertInstanceOf( '\\Aimeos\\MShop\\Common\\Item\\Lists\\Iface', $listItem );
		$this->assertEquals( 1, count( $listItems ) );

		$this->assertEquals( 1, $listItem->getStatus() );
		$this->assertEquals( 0, $listItem->getPosition() );
		$this->assertEquals( 'text', $listItem->getDomain() );
		$this->assertEquals( 'default', $listItem->getType() );

		$refItem = $listItem->getRefItem();

		$this->assertEquals( 1, $refItem->getStatus() );
		$this->assertEquals( 'name', $refItem->getType() );
		$this->assertEquals( 'catalog', $refItem->getDomain() );
		$this->assertEquals( 'test text', $refItem->getLabel() );
		$this->assertEquals( 'Job CSV test', $refItem->getContent() );
		$this->assertEquals( 'de', $refItem->getLanguageId() );
		$this->assertEquals( 1, $refItem->getStatus() );
	}


	public function testProcessMultiple()
	{
		$mapping = array(
			0 => 'text.type',
			1 => 'text.content',
			2 => 'text.type',
			3 => 'text.content',
			4 => 'text.type',
			5 => 'text.content',
			6 => 'text.type',
			7 => 'text.content',
		);

		$data = array(
			0 => 'name',
			1 => 'Job CSV test',
			2 => 'short',
			3 => 'Short: Job CSV test',
			4 => 'long',
			5 => 'Long: Job CSV test',
			6 => 'long',
			7 => 'Long: Job CSV test 2',
		);

		$catalog = $this->create( 'job_csv_test' );

		$object = new \Aimeos\Controller\Common\Catalog\Import\Csv\Processor\Text\Standard( $this->context, $mapping, $this->endpoint );
		$object->process( $catalog, $data );

		$catalog = $this->get( 'job_csv_test' );
		$this->delete( $catalog );


		$pos = 0;
		$listItems = $catalog->getListItems();
		$expected = array(
			0 => array( 'name', 'Job CSV test' ),
			1 => array( 'short', 'Short: Job CSV test' ),
			2 => array( 'long', 'Long: Job CSV test' ),
			3 => array( 'long', 'Long: Job CSV test 2' ),
		);

		$this->assertEquals( 4, count( $listItems ) );

		foreach( $listItems as $listItem )
		{
			$this->assertEquals( $expected[$pos][0], $listItem->getRefItem()->getType() );
			$this->assertEquals( $expected[$pos][1], $listItem->getRefItem()->getContent() );
			$pos++;
		}
	}


	public function testProcessUpdate()
	{
		$mapping = array(
			0 => 'text.type',
			1 => 'text.content',
		);

		$data = array(
			0 => 'name',
			1 => 'Job CSV test',
		);

		$dataUpdate = array(
			0 => 'short',
			1 => 'Short: Job CSV test',
		);

		$catalog = $this->create( 'job_csv_test' );

		$object = new \Aimeos\Controller\Common\Catalog\Import\Csv\Processor\Text\Standard( $this->context, $mapping, $this->endpoint );
		$object->process( $catalog, $data );

		$catalog = $this->get( 'job_csv_test' );

		$object->process( $catalog, $dataUpdate );

		$catalog = $this->get( 'job_csv_test' );
		$this->delete( $catalog );


		$listItems = $catalog->getListItems();
		$listItem = reset( $listItems );

		$this->assertEquals( 1, count( $listItems ) );
		$this->assertInstanceOf( '\\Aimeos\\MShop\\Common\\Item\\Lists\\Iface', $listItem );

		$this->assertEquals( 'short', $listItem->getRefItem()->getType() );
		$this->assertEquals( 'Short: Job CSV test', $listItem->getRefItem()->getContent() );
	}


	public function testProcessDelete()
	{
		$mapping = array(
			0 => 'text.type',
			1 => 'text.content',
		);

		$data = array(
			0 => 'name',
			1 => 'Job CSV test',
		);

		$catalog = $this->create( 'job_csv_test' );

		$object = new \Aimeos\Controller\Common\Catalog\Import\Csv\Processor\Text\Standard( $this->context, $mapping, $this->endpoint );
		$object->process( $catalog, $data );

		$catalog = $this->get( 'job_csv_test' );

		$object = new \Aimeos\Controller\Common\Catalog\Import\Csv\Processor\Text\Standard( $this->context, [], $this->endpoint );
		$object->process( $catalog, [] );

		$catalog = $this->get( 'job_csv_test' );
		$this->delete( $catalog );


		$listItems = $catalog->getListItems();

		$this->assertEquals( 0, count( $listItems ) );
	}


	public function testProcessEmpty()
	{
		$mapping = array(
			0 => 'text.type',
			1 => 'text.content',
			2 => 'text.type',
			3 => 'text.content',
		);

		$data = array(
			0 => 'name',
			1 => 'Job CSV test',
			2 => '',
			3 => '',
		);

		$catalog = $this->create( 'job_csv_test' );

		$object = new \Aimeos\Controller\Common\Catalog\Import\Csv\Processor\Text\Standard( $this->context, $mapping, $this->endpoint );
		$object->process( $catalog, $data );

		$catalog = $this->get( 'job_csv_test' );
		$this->delete( $catalog );


		$listItems = $catalog->getListItems();

		$this->assertEquals( 1, count( $listItems ) );
	}


	public function testProcessListtypes()
	{
		$mapping = array(
			0 => 'text.type',
			1 => 'text.content',
			2 => 'catalog.lists.type',
			3 => 'text.type',
			4 => 'text.content',
			5 => 'catalog.lists.type',
		);

		$data = array(
			0 => 'name',
			1 => 'test name',
			2 => 'test',
			3 => 'short',
			4 => 'test short',
			5 => 'default',
		);

		$this->context->getConfig()->set( 'controller/common/catalog/import/csv/processor/text/listtypes', array( 'default' ) );

		$catalog = $this->create( 'job_csv_test' );

		$object = new \Aimeos\Controller\Common\Catalog\Import\Csv\Processor\Text\Standard( $this->context, $mapping, $this->endpoint );
		$object->process( $catalog, $data );

		$catalog = $this->get( 'job_csv_test' );
		$this->delete( $catalog );


		$listItems = $catalog->getListItems();
		$listItem = reset( $listItems );

		$this->assertEquals( 1, count( $listItems ) );
		$this->assertInstanceOf( '\\Aimeos\\MShop\\Common\\Item\\Lists\\Iface', $listItem );

		$this->assertEquals( 'default', $listItem->getType() );
		$this->assertEquals( 'short', $listItem->getRefItem()->getType() );
		$this->assertEquals( 'test short', $listItem->getRefItem()->getContent() );
	}


	/**
	 * @param string $code
	 */
	protected function create( $code )
	{
		$manager = \Aimeos\MShop\Catalog\Manager\Factory::createManager( $this->context );

		$item = $manager->createItem();
		$item->setCode( $code );

		return $manager->insertItem( $item );
	}


	protected function delete( \Aimeos\MShop\Catalog\Item\Iface $catalog )
	{
		$textManager = \Aimeos\MShop\Text\Manager\Factory::createManager( $this->context );
		$manager = \Aimeos\MShop\Catalog\Manager\Factory::createManager( $this->context );
		$listManager = $manager->getSubManager( 'lists' );

		foreach( $catalog->getListItems('text') as $listItem )
		{
			$textManager->deleteItem( $listItem->getRefItem()->getId() );
			$listManager->deleteItem( $listItem->getId() );
		}

		$manager->deleteItem( $catalog->getId() );
	}


	/**
	 * @param string $code
	 */
	protected function get( $code )
	{
		$manager = \Aimeos\MShop\Catalog\Manager\Factory::createManager( $this->context );
		return $manager->findItem( $code, ['text'] );
	}
}