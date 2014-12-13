<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/8/14
 * Time: 4:26 PM
 */

namespace Application\Api\RateSeat\V1\Admin\RequestHandler\User\Load;

use Application\Api\Base\Server\BaseRequestHandler;


class UserLoadRequestHandler extends BaseRequestHandler
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


        return $this;
    }


} 