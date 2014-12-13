<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 9/16/13
 * Time: 11:56 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Lib\Rpc\JsonRpc\Server;


/**
 * Class RpcResponseVo
 *
 * @package Application\Lib\Rpc\JsonRpc\Server
 */
class RpcResponseVo extends RpcBaseVo
{

    /**
     * @return mixed
     */
    public function getResult()
    {
        $key = 'result';

        $value = $this->getDataKey($key);

        return $value;
    }

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setResult($value)
    {
        $key = 'result';

        $value = $this->setDataKey($key, $value);

        return $value;
    }

    /**
     * @return $this
     */
    public function unsetResult()
    {
        $key = 'result';

        $value = $this->setDataKey($key, null);

        return $value;
    }


    /**
     * @return array
     */
    public function getError()
    {
        $result = null;
        $key = 'error';

        $value = $this->getDataKey($key);
        $isValid = is_array($value);

        if ($isValid) {

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
    public function setError($value)
    {
        $key = 'error';

        $isValid = is_array($value);
        if (!$isValid) {

            throw new \Exception('Invalid parameter "value" ! ' . __METHOD__);
        }

        $this->setDataKey($key, $value);

        return $this;
    }

    /**
     * @return $this
     */
    public function unsetError()
    {
        $key = 'error';

        $value = $this->setDataKey($key, null);

        return $value;
    }


    /**
     * @return int|string|float|null
     */
    public function getId()
    {
        $result = null;
        $key = 'id';

        $value = $this->getDataKey($key);
        $isValid = is_scalar($value);

        if ($isValid) {

            return $value;
        }

        return $result;
    }

    /**
     * @param int|string|float|null $value
     *
     * @return $this
     * @throws \Exception
     */
    public function setId($value)
    {
        $key = 'id';

        $isValid = $value === null || is_scalar($value);

        if (!$isValid) {

            throw new \Exception('Invalid parameter "value" ! ' . __METHOD__);
        }

        $this->setDataKey($key, $value);

        return $this;
    }

    /**
     * @return $this
     */
    public function unsetId()
    {
        $key = 'id';

        $value = $this->setDataKey($key, null);

        return $value;
    }


}