<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2017
 */


namespace Aimeos\MW\Logger;


class Laravel5Test extends \PHPUnit\Framework\TestCase
{
	private $mock;
	private $object;


	protected function setUp()
	{
		if( interface_exists( '\\Illuminate\\Contracts\\Logging\\Log' ) === false ) {
			$this->markTestSkipped( 'Class \\Illuminate\\Contracts\\Logging\\Log not found' );
		}

		$this->mock = $this->getMockBuilder( '\\Illuminate\\Contracts\\Logging\\Log' )->getMock();
		$this->object = new \Aimeos\MW\Logger\Laravel5( $this->mock );
	}


	protected function tearDown()
	{
		unset( $this->mock, $this->object );
	}


	public function testLog()
	{
		$this->mock->expects( $this->once() )->method( 'log' )
			->with( $this->equalTo( 'msg' ), $this->equalTo( 'error' ) );
		$this->object->log( 'msg' );
	}


	public function testNonScalarLog()
	{
		$this->mock->expects( $this->once() )->method( 'log' )
			->with( $this->equalTo( '["error","error2",2]' ), $this->equalTo( 'error' ) );
		$this->object->log( array( 'error', 'error2', 2 ) );
	}


	public function testLogDebug()
	{
		$this->object->log( 'emergency', \Aimeos\MW\Logger\Base::EMERG );
		$this->object->log( 'alert', \Aimeos\MW\Logger\Base::ALERT );
		$this->object->log( 'critical', \Aimeos\MW\Logger\Base::CRIT );
		$this->object->log( 'error', \Aimeos\MW\Logger\Base::ERR );
		$this->object->log( 'warning', \Aimeos\MW\Logger\Base::WARN );
		$this->object->log( 'notice', \Aimeos\MW\Logger\Base::NOTICE );
		$this->object->log( 'info', \Aimeos\MW\Logger\Base::INFO );
		$this->object->log( 'debug', \Aimeos\MW\Logger\Base::DEBUG );
	}


	public function testBadPriority()
	{
		$this->setExpectedException( '\\Aimeos\\MW\\Logger\\Exception' );
		$this->object->log( 'error', -1 );
	}
}
