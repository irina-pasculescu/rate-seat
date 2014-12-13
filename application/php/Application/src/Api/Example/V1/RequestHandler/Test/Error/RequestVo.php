<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/24/14
 * Time: 12:06 PM
 */

namespace Application\Api\Example\V1\RequestHandler\Test\Error;


use Application\Api\Base\Server\BaseRequestException as RequestException;
use Application\Api\Base\Server\BaseRequestVo;

/**
 * Class RequestVo
 *
 * @package Application\Api\Example\V1\RequestHandler\Test\Error
 */
class RequestVo extends BaseRequestVo
{


    // ======== implement abstracts =========

    /**
     * @return $this
     * @throws RequestException
     */
    public function validate()
    {
        return $this;
    }


} 