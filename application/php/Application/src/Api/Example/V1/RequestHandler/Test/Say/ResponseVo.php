<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/24/14
 * Time: 12:08 PM
 */

namespace Application\Api\Example\V1\RequestHandler\Test\Say;

use Application\Api\Base\Server\BaseResponseVo;

/**
 * Class ResponseVo
 *
 * @package Application\Api\Example\V1\RequestHandler\Test\Say
 */
class ResponseVo extends BaseResponseVo
{


    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setMessage($value)
    {
        $this->setDataKey('message', $value);

        return $this;
    }

} 