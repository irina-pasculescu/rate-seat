<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/24/14
 * Time: 12:08 PM
 */

namespace Application\Api\Example\V1\RequestHandler\Test\Ping;

use Application\Api\Base\Server\BaseResponseVo;

/**
 * Class ResponseVo
 *
 * @package Application\Api\Example\V1\RequestHandler\Test\Ping
 */
class ResponseVo extends BaseResponseVo
{


    /**
     * @param bool $value
     *
     * @return $this
     */
    public function setPong($value)
    {
        $this->setDataKey('pong', $value);

        return $this;
    }

} 