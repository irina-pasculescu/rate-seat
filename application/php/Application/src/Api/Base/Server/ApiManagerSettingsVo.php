<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/24/14
 * Time: 9:40 AM
 */
namespace Application\Api\Base\Server;

use Application\BaseVo;

/**
 * Class ApiManagerSettingsVo
 *
 * @package Application\Api\Base\Server
 */
abstract class ApiManagerSettingsVo extends BaseVo
{

    const FEATURE_NAME = 'RateSeat.Api.Base.ApiManager';

    const DATA_KEY_ENABLED          = 'enabled';
    const DATA_KEY_IS_DEBUG_ENABLED = 'isDebugEnabled';


    /**
     * @return bool
     */
    public function getEnabled()
    {
        return $this->getDataKey( $this::DATA_KEY_ENABLED ) === true;
    }

    /**
     * @return bool
     */
    public function getIsDebugEnabled()
    {
        return $this->getDataKey( $this::DATA_KEY_IS_DEBUG_ENABLED ) === true;
    }

    /**
     * @return bool
     */
    public function onErrorLogRpcRequestEnabled()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function onErrorLogRpcResponseEnabled()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function onErrorLogRpcResponseDebugEnabled()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function onSuccessLogRpcRequestEnabled()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function onSuccessLogRpcResponseEnabled()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function onSuccessLogRpcResponseDebugEnabled()
    {
        return true;
    }


    /**
     * @throws ApiManagerSettingsVoException
     * @return $this
     */
    abstract public function validate();
} 