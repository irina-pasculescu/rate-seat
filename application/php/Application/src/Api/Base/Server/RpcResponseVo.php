<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 9/16/13
 * Time: 2:28 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Api\Base\Server;

use Application\Lib\Rpc\JsonRpc\Server\RpcResponseVo as BaseRpcResponseVo;

/**
 * Class RpcResponseVo
 *
 * @package Application\Api\Base\Server
 */
class RpcResponseVo extends BaseRpcResponseVo
{


    /**
     * @return array
     */
    public function getDebug()
    {
        $result = array();
        $key = 'debug';

        $value = $this->getDataKey($key);
        if (is_array($value)) {

            return $value;
        }

        return $result;
    }

    /**
     * @param array $value
     *
     * @return $this
     * @throws \Exception
     */
    public function setDebug($value)
    {
        $key = 'debug';

        if (!is_array($value)) {

            throw new \Exception('Invalid parameter "value" ! ' . __METHOD__);
        }

        $value = $this->setDataKey($key, $value);

        return $value;
    }

    /**
     * @return $this
     */
    public function unsetDebug()
    {
        $key = 'debug';

        $value = $this->setDataKey($key, null);

        return $value;
    }
}