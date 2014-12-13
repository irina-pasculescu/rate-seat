<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/9/14
 * Time: 10:36 AM
 */

namespace Application\Api\Base\Server;

use Application\Api\Base\Server\BaseRequestException as RequestException;
use Application\BaseVo;

/**
 * Class BaseRequestVo
 *
 * @package Application\Api\Base\Server
 */
abstract class BaseRequestVo extends BaseVo
{

    /**
     * @return $this
     * @throws RequestException
     */
    abstract public function validate();
} 