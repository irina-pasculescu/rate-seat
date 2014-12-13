<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/12/14
 * Time: 11:17 AM
 */

namespace Application\Lib\RateSeat\RestApiClient\Api\Base\Request;


use Application\BaseVo;

abstract class BaseRateSeatApiClientRequestVo extends BaseVo
{

    /**
     * @return array
     */
    public function exportData()
    {
        return $this->getData();
    }

} 