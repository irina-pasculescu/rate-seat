<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/9/14
 * Time: 10:36 AM
 */

namespace Application\Api\Base\Server;


use Application\BaseVo;

/**
 * Class BaseResponseVo
 *
 * @package Application\Api\Base\Server
 */
class BaseResponseVo extends BaseVo
{

    /**
     * @return array
     */
    public function export()
    {
        return $this->getData();

    }

} 