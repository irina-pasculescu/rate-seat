<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 4/22/13
 * Time: 11:32 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Api\Base\Server;

use Application\Lib\Rpc\JsonRpc\Server\RpcDispatcher as AbstractDispatcher;

/**
 * Class RpcDispatcherHttp
 *
 * @package Application\Api\Base\Server
 */
class RpcDispatcherHttp extends AbstractDispatcher
{

    /**
     * override just for proper type hinting in ide
     *
     * @return RpcFactory
     */
    protected function getFactory()
    {
        return $this->factory;
    }

    /**
     * @return $this
     */
    public function run()
    {
        $apiManager = $this->getFactory()
            ->getApiManager();


        $apiManager->initRoutesHttp();
        $apiManager->initRouterCallbacks();

        $rpcFactory = $this->getFactory();
        $router = $rpcFactory->getRouter();

        $router->setRequestData(
            $this->fetchRequestData()
        )
            ->route()
            ->sendResponse();


        return $this;
    }

    /**
     * @return array|mixed|null
     */
    protected function fetchRequestData()
    {
        $rpcFactory = $this->getFactory();
        $router = $rpcFactory->getRouter();

        $requestText = $router->fetchRequestText();
        $requestData = $router->decodeJson($requestText, true, false);

        return $requestData;
    }


}