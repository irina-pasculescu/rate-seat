<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 11/18/13
 * Time: 1:27 PM
 */
namespace Application\Api\Example\V1\Service;

use
    Application\Api\Example\V1\RequestHandler\Test\Error\TestErrorRequestHandler;
use
    Application\Api\Example\V1\RequestHandler\Test\GetDate\TestGetDateRequestHandler;
use Application\Api\Example\V1\RequestHandler\Test\Ping\TestPingRequestHandler;
use Application\Api\Example\V1\RequestHandler\Test\Say\TestSayRequestHandler;
use Application\Api\Example\V1\Server\RpcService;

/**
 * Class Test
 *
 * @package Application\Api\Example\V1\Service
 */
class Test extends RpcService
{

    /*

    Example
    =======

    {
        "method": "Example.Test.ping"
    }

    */

    /**
     * @param array $request
     *
     * @return array
     */
    public function ping($request = array())
    {
        $rpc = $this->getRpc();
        $rpcContext = $rpc->getRpcContext();
        $requestHandler = new TestPingRequestHandler($rpcContext);

        return $requestHandler->handleRequest($request);
    }


    /*

    Example
    =======

    {
        "method": "Example.Test.say",
        "params":[
            {
                "message":"hello world!"
            }
        ]
    }

    */


    /**
     * @param array $request
     *
     * @return array
     */
    public function say($request = array())
    {
        $rpc = $this->getRpc();
        $rpcContext = $rpc->getRpcContext();

        $requestHandler = new TestSayRequestHandler($rpcContext);

        return $requestHandler->handleRequest($request);
    }

    /*

    Example
    =======

    {
        "method": "Example.Test.error"
    }

    */

    /**
     * @param array $request
     *
     * @return array
     */
    public function error($request = array())
    {
        $rpc = $this->getRpc();
        $rpcContext = $rpc->getRpcContext();

        $requestHandler = new TestErrorRequestHandler($rpcContext);

        return $requestHandler->handleRequest($request);
    }


    /*

      Example
      =======

      {
          "method": "Example.Test.getDate",
          "params":[
              {
                  "date":"now"
              }
          ]
      }

    */

    /**
     * @param array $request
     *
     * @return array
     */
    public function getDate($request = array())
    {
        $rpc = $this->getRpc();
        $rpcContext = $rpc->getRpcContext();

        $requestHandler = new TestGetDateRequestHandler($rpcContext);

        return $requestHandler->handleRequest($request);
    }


}