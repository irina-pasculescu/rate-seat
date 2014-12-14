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
 * Class RpcRequestVo
 *
 * @package Application\Lib\Rpc\JsonRpc\Server
 */
class RpcRequestVo extends RpcBaseVo
{

    /**
     * @return string
     */
    public function getMethod()
    {
        $result = '';
        $key    = 'method';

        $value   = $this->getDataKey( $key );
        $isValid = is_string( $value ) && ( !empty( $value ) );

        if ( $isValid ) {

            return $value;
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $result = array();
        $key    = 'params';

        $value = $this->getDataKey( $key );
        if ( $value === null ) {
            $value = array();
        }
        $isValid = is_array( $value );

        if ( $isValid ) {

            return $value;
        }

        return $result;
    }

    /**
     * @return int|string|float|null
     */
    public function getId()
    {
        $result = null;
        $key    = 'id';

        $value   = $this->getDataKey( $key );
        $isValid = is_scalar( $value );

        if ( $isValid ) {

            return $value;
        }

        return $result;
    }

}