<?php
namespace ModulesTests\Openvpn;
 
use PHPUnit_Framework_TestCase;
use ModulesTests\ServiceManagerGrabber;
 
class ClientConfigTest extends PHPUnit_Framework_TestCase
{
    // service manager
    protected $sm;
    protected $account = 'phpunitClient1';
     
    public function setUp()
    {
        $serviceManagerGrabber   = new ServiceManagerGrabber();
        $this->sm = $serviceManagerGrabber->getServiceManager();
    }
     
    public function testBuildkey()
    {
        //$account = 'phpunitClient1';
        $clientKey = $this->sm->get('Lib\Openvpn\Model\ClientKey');
        $clientKey->buildKey( $this->account );
        //$clientKeyMapper = $sm->get('Lib\Openvpn\Mapper\ClientKey')->save($clientKey); 

        $this->assertEquals( $this->account, $clientKey->getAccountId() );
        $this->assertNotEmpty( $clientKey->getCrt() );
        $this->assertNotEmpty( $clientKey->getKey() );
        $this->assertNotEmpty( $clientKey->getCsr() );
        $this->assertNotEmpty( $clientKey->getModified() );
        //($count > 0 ) ? $this->assertNotEmpty($count) : $this->assertEmpty($count);
    }

    public function testBuildConfig()
    {
        // setup param
        $clientParam = $this->sm->get('Lib\Openvpn\Model\ClientParam');
        $clientParam->setAccountId($this->account);
        $clientParam->addParam('dev', 'phpunit-dev');
        $clientParam->addParam('verb', '1');
        $clientParam->addParam('proto', 'phpunit-proto');
        $this->sm->get('Lib\Openvpn\Mapper\ClientParam')->save($clientParam);

        // build config
        $clientConfig = $this->sm->get('Lib\Openvpn\Model\ClientConfig');
        $config = $clientConfig->getConfigFile($this->account, 'us1');
        $this->assertNotEmpty( $config );

        // check params
        preg_match("/\r\ndev\s(.*)/", $config, $matches);
        $paramDev = $matches[1];
        $this->assertEquals( 'phpunit-dev', $paramDev );

        preg_match("/\r\nverb\s(.*)/", $config, $matches);
        $paramVerb = $matches[1];
        $this->assertEquals( '1', $paramVerb );

        preg_match("/\r\nproto\s(.*)/", $config, $matches);
        $paramProto = $matches[1];
        $this->assertEquals( 'phpunit-proto', $paramProto );

        // check crt & key
        preg_match("/<cert>\r\n(.*)\r\n<\/cert>/s", $config, $matches);
        $crt = $matches[1];
        $this->assertNotEmpty( $crt );
        preg_match("/<key>\r\n(.*)\r\n<\/key>/s", $config, $matches);
        $key = $matches[1];
        $this->assertNotEmpty( $key );


    }

}
