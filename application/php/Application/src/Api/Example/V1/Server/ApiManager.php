<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/24/14
 * Time: 9:39 AM
 */
namespace Application\Api\Example\V1\Server;


use Application\Api\Base\Server\ApiManager as BaseApiManager;


/**
 * Class ApiManager
 *
 * @package Application\Api\Example\V1
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
        if (!$this->settingsVo) {
            $this->settingsVo = $this->getRpcFactory()
                ->createApiManagerSettingsVo();
            $settingsMvo = $this->getModel()->getApplicationSettingsMvo();
            $settingsData = $settingsMvo->getDataKey($this->getFeatureName());
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

        $rpc = $router->getRpc();
        $rpcContext = new RpcContext();
        $rpc->setRpcContext($rpcContext);

        return $this;
    }

    // ================== overrides ================


    /**
     * @var array
     */
    protected $routes
        = array(

            // Example.Test.*
            'Example.Test.ping' => array(
                'target' =>
                    '\\Application\\Api\\Example\\V1\\Service\\Test::ping'
            ),
            'Example.Test.say' => array(
                'target' =>
                    '\\Application\\Api\\Example\\V1\\Service\\Test::say'
            ),
            'Example.Test.getDate' => array(
                'target' =>
                    '\\Application\\Api\\Example\\V1\\Service\\Test::getDate'
            ),
            'Example.Test.error' => array(
                'target' =>
                    '\\Application\\Api\\Example\\V1\\Service\\Test::error'
            ),
        );


}