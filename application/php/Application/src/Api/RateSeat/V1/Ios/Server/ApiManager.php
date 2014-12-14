<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/24/14
 * Time: 9:39 AM
 */
namespace Application\Api\RateSeat\V1\Ios\Server;


use Application\Api\Base\Server\ApiManager as BaseApiManager;


/**
 * Class ApiManager
 *
 * @package Application\Api\RateSeat\V1
 */
class ApiManager extends BaseApiManager
{


    // ================ implement abstracts ========
    /**
     * @return RpcFactory
     */
    public function getRpcFactory()
    {

        return $this->rpcFactory;
    }

    /**
     *
     * @return ApiManagerSettingsVo
     */
    public function getSettingsVo()
    {
        if ( !$this->settingsVo ) {
            $this->settingsVo = $this->getRpcFactory()
                                     ->createApiManagerSettingsVo();
            $settingsMvo      = $this->getModel()->getApplicationSettingsMvo();
            $settingsData     = $settingsMvo->getDataKey( $this->getFeatureName() );
            $this->settingsVo->setData(
                $settingsData
            );
        }

        return $this->settingsVo;
    }


    /**
     * @return string
     */
    public function getFeatureName()
    {
        return ApiManagerSettingsVo::FEATURE_NAME;
    }

    /**
     *
     * @return $this
     */
    protected function prepareContext()
    {
        $router = $this->getRpcFactory()->getRouter();

        $rpc        = $router->getRpc();
        $rpcContext = new RpcContext();
        $rpc->setRpcContext( $rpcContext );

        return $this;
    }

    // ================== overrides ================
    /**
     * @return array
     */
    protected function getRoutes()
    {

        $routesFinal = (array)$this->routes;

        return $routesFinal;
    }

    /**
     * @var array
     */
    protected $routes
        = array(
            // Application\Api\RateSeat\V1\Ios\Service\Lufthansa
            // RateSeat.Ios.Lufthansa.*
            'RateSeat.Ios.Lufthansa.FlightStatus.get' => array(
                'target' =>
                    '\\Application\Api\RateSeat\V1\Ios\Service\\Lufthansa\\FlightStatus::get'
            ),
            'RateSeat.Ios.Lufthansa.OffersSeats.get'  => array(
                'target' =>
                    '\\Application\Api\RateSeat\V1\Ios\Service\\Lufthansa\\OffersSeats::get'
            ),

        );


}