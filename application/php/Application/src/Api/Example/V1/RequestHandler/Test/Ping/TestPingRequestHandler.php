<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/24/14
 * Time: 12:05 PM
 */
namespace Application\Api\Example\V1\RequestHandler\Test\Ping;

use Application\Api\Base\Server\BaseRequestHandler;

/**
 * Class TestPingRequestHandler
 *
 * @package Application\Api\Example\V1\RequestHandler\Test\Ping
 */
class TestPingRequestHandler extends BaseRequestHandler
{


    // ============= implement abstracts ==============

    /**
     * @return RequestVo
     */
    protected function getRequestVo()
    {
        if (!$this->requestVo) {
            $this->requestVo = new RequestVo();
        }

        return $this->requestVo;
    }

    /**
     * @return ResponseVo
     */
    protected function getResponseVo()
    {
        if (!$this->responseVo) {
            $this->responseVo = new ResponseVo();
        }

        return $this->responseVo;
    }


    /**
     * @throws \Exception
     * @return $this
     */
    protected function execute()
    {
        $responseVo = $this->getResponseVo();

        $responseVo->setPong(true);

        return $this;
    }


} 