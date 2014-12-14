<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/11/14
 * Time: 3:30 PM
 */

namespace Application\Api\RateSeat\V1\Shared;


use Application\Context;
use Application\Mvo\ApplicationSettings\ApplicationSettingsMvo;
use Application\Mvo\ApplicationSettings\RateSeatApiClientSettingsVo;
use Application\Utils\ClassUtil;

/**
 * Class RateSeatApiSettingsManager
 * @package Application\Api\RateSeat\V1\Shared
 */
class RateSeatApiSettingsManager
{

    /**
     * @var self
     */
    private static $instance;

    /**
     * @return RateSeatApiSettingsManager
     */
    public static function getInstance()
    {
        if ( !self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return Context
     */
    private function getApplicationContext()
    {
        return Context::getInstance();
    }

    /**
     * @return ApplicationSettingsMvo
     */
    private function getApplicationSettingsMvo()
    {
        return $this->getApplicationContext()
                    ->getModel()
                    ->getApplicationSettingsMvo();
    }

    /**
     * @var RateSeatApiClientSettingsVo
     */
    private $apiClientSettingsVo;

    /**
     * @return RateSeatApiClientSettingsVo
     * @throws \Exception
     */
    public function getApiClientSettingsVo()
    {
        $method = ClassUtil::getQualifiedMethodName( $this, __METHOD__, true );

        if ( !$this->apiClientSettingsVo ) {

            $mvo = $this->getApplicationSettingsMvo();
            $this->apiClientSettingsVo
                 = $mvo
                ->getRateSeatApiClientSettingsVo();

            try {
                $this->apiClientSettingsVo->validate();
            }
            catch (\Exception $e) {

                throw new \Exception(
                    'Invalid ApplicationSettings.' . $mvo::KEY_RATE_SEAT_API_CLIENT . ' ! '
                    . ' (' . $method . ')'
                    . ' details: ' . $e->getMessage()
                );
            }

        }

        return $this->apiClientSettingsVo;
    }


}