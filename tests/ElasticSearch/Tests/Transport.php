<?php

namespace ElasticSearch\Tests;
use ElasticSearch;

/**
 * Class Transport
 *
 * @category   Tests
 * @package    ElasticSearch
 * @subpackage Tests
 * @author     Zachary Tong <zachary.tong@elasticsearch.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0 Apache2
 * @link       http://elasticsearch.org
 */
class Transport extends \PHPUnit_Framework_TestCase
{


    /**
     * @param $exception
     * @param $code
     */
    public function assertThrowsException($exception, $code)
    {
        $raisedException = null;
        try {
            $code();
        } catch (\Exception $raisedException) {
            // No more code, we only want to catch the exception in $e.
        }

        $this->assertInstanceOf($exception, $raisedException);

    }//end assertThrowsException()


    /**
     * Test null constructors
     *
     * @expectedException \ElasticSearch\Common\Exceptions\BadMethodCallException
     * @expectedExceptionMessage Hosts parameter must be set
     *
     * @covers Transport::__construct
     * @return void
     */
    public function testNullConstructor()
    {
        $hosts = null;
        $params = null;
        // Empty constructor.
        $transport = new ElasticSearch\Transport($hosts, $params);

    }//end testNullConstructor()


    /**
     * Test string constructors
     *
     * @expectedException \ElasticSearch\Common\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Hosts parameter must be an array
     *
     * @covers Transport::__construct
     * @return void
     */
    public function testStringConstructor()
    {
        $hosts     = 'arbitrary string';
        $params    = 'arbitrary string';
        $transport = new ElasticSearch\Transport($hosts, $params);

    }//end testStringConstructor()


    /**
     * Test invalid host array being passed
     *
     * @expectedException \ElasticSearch\Common\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Host parameter must be an array
     *
     * @covers Transport::addConnection
     * @return void
     */
    public function testAddConnectionWithInvalidString()
    {
        $hosts = array(array('host' => 'localhost', 'port' => 9200));
        $that = $this;
        $dicParams['connectionPool'] = function () use ($that) { return $that->getMock('ConnectionPool'); };
        $dicParams['connection']     = function () use ($that) { return $that->getMock('Connection'); };

        $transport = new ElasticSearch\Transport($hosts, $dicParams);
        $transport->addConnection('arbitrary string');

    }//end testAddConnectionWithInvalidString()


    /**
     * Test invalid host array - no hostname
     *
     * @expectedException \ElasticSearch\Common\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Host must be provided in host parameter
     *
     * @covers Transport::addConnection
     * @return void
     */
    public function testAddConnectionWithMissingHost()
    {
        $hosts = array(array('host' => 'localhost', 'port' => 9200));
        $that = $this;
        $dicParams['connectionPool'] = function () use ($that) { return $that->getMock('ConnectionPool'); };
        $dicParams['connection']     = function () use ($that) { return $that->getMock('Connection'); };

        $transport = new ElasticSearch\Transport($hosts, $dicParams);

        $host = array('port' => 9200);
        $transport->addConnection($host);

    }//end testAddConnectionWithMissingHost()


    /**
     * Test invalid host array - non-numeric port
     *
     * @expectedException \ElasticSearch\Common\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Port must be numeric
     *
     * @covers Transport::addConnection
     * @return void
     */
    public function testAddConnectionWithNonNumericPort()
    {
        $hosts = array(array('host' => 'localhost', 'port' => 9200));
        $that = $this;
        $dicParams['connectionPool'] = function () use ($that) { return $that->getMock('ConnectionPool'); };
        $dicParams['connection']     = function () use ($that) { return $that->getMock('Connection'); };

        $transport = new ElasticSearch\Transport($hosts, $dicParams);

        $host = array(
                 'host' => 'localhost',
                 'port' => 'abc',
                );

        $transport->addConnection($host);

    }//end testAddConnectionWithNonNumericPort()


}//end class