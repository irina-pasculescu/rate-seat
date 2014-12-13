<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/8/14
 * Time: 4:26 PM
 */

namespace Application\Api\RateSeat\V1\Admin\RequestHandler\GameSession\Create;

use Application\Api\RateSeat\V1\Base\BaseWhowApiRequestHandler;
use Application\Definition\RateSeatApi\WhowModel\Game\WhowGameIdType;
use Application\Definition\RateSeatApi\WhowModel\User\WhowUserIdType;
use
    Application\Lib\RateSeatApi\RestApiClient\Api\FlightStatus\Load\RateSeatApiClientRequestHandler;

/**
 * Class GameSessionCreateRequestHandler
 * @package Application\Api\RateSeat\V1\Admin\RequestHandler\GameSession\Create
 */
class GameSessionCreateRequestHandler extends BaseWhowApiRequestHandler
{


    // ============= implement abstracts ==============

    /**
     * @return RequestVo
     */
    protected function getRequestVo()
    {
        if (!$this->requestVo) {
            $this->requestVo = new RequestVo();
        }

        return $this->requestVo;
    }

    /**
     * @return ResponseVo
     */
    protected function getResponseVo()
    {
        if (!$this->responseVo) {
            $this->responseVo = new ResponseVo();
        }

        return $this->responseVo;
    }


    /**
     * @throws \Exception
     * @return $this
     */
    protected function execute()
    {
        $requestVo = $this->getRequestVo();

        $whowUserIdValue = $requestVo->getUserId();
        $whowUserId = new WhowUserIdType(
            $whowUserIdValue,
            'Invalid whowUserId ! ' . json_encode($whowUserIdValue)
        );
        $whowGameIdValue = $requestVo->getGameId();
        $whowGameId = new WhowGameIdType(
            $whowGameIdValue,
            'Invalid whowGameId ! ' . json_encode($whowGameIdValue)
        );


        // create whow api request
        $whowApiRequest = new WhowApiClientRequest(
            $whowUserId,
            $whowGameId
        );

        // execute whow api request
        $whowApiClientFacade = $this->getWhowApiClientFacade();
        $clientStatus = $whowApiClientFacade->makeRequest(
            $whowApiClientFacade->getRestApiClientConfigVo(),
            $whowApiClientFacade->getHttpClientOptionsVo(),
            $whowApiRequest,
            $this->getRequestTimestamp()
        );

        // handle whow api response
        if ($clientStatus->hasException()) {
            // delegate?
            throw $clientStatus->getException();
        }

        $whowResponse = array(
            'body' => $clientStatus->getResponseBodyData(),
            'status' => $clientStatus->getResponseHttpStatusCode(),
            'duration' => $clientStatus->getDuration(),
        );

        $responseVo = $this->getResponseVo();
        $responseVo->setDataKey('_whow', $whowResponse);


        return $this;
    }


}