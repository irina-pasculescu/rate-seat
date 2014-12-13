<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/8/14
 * Time: 4:26 PM
 */

namespace Application\Api\RateSeat\V1\Ios\RequestHandler\Lufthansa\OffersSeatMaps\Load;


use Application\Api\RateSeat\V1\Base\BaseWhowApiRequestHandler;
use Application\Definition\RateSeatApi\WhowModel\Session\SessionTokenType;
use
    Application\Lib\RateSeatApi\RestApiClient\Api\GameSessions\Load\WhowApiClientRequest;

/**
 * Class PlayerGameSessionLoadRequestHandler
 * @package Application\Api\RateSeat\V1\Game\RequestHandler\Player\GameSession\Load
 */
class OffersSeatMapsLoadRequestHandler extends BaseWhowApiRequestHandler
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
        $sessionTokenValue = $requestVo->getSessionToken();
        $sessionToken = new SessionTokenType(
            $sessionTokenValue,
            'Invalid request.apiToken: ' . json_encode(
                $sessionTokenValue
            ) . ' !'
        );

        // create whow api request
        $whowApiRequest = new WhowApiClientRequest(
            $sessionToken
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