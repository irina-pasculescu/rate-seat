<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/24/14
 * Time: 12:05 PM
 */
namespace Application\Api\Example\V1\RequestHandler\Test\Error;

use Application\Api\Base\Server\BaseRequestHandler;
use Application\Exception as ApplicationException;
use Application\Utils\ClassUtil;

/**
 * Class TestErrorRequestHandler
 *
 * @package Application\Api\Example\V1\RequestHandler\Test\Error
 */
class TestErrorRequestHandler extends BaseRequestHandler
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
     * @return void
     * @throws \Application\Exception
     */
    protected function execute()
    {

        throw new ApplicationException(
            'FooBarException at ' . ClassUtil::getQualifiedMethodName(
                $this,
                __METHOD__,
                true
            )
        );


    }


} 