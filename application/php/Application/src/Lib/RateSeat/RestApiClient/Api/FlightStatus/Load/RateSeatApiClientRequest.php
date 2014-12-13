<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/12/14
 * Time: 10:58 AM
 */

namespace Application\Lib\RateSeat\RestApiClient\Api\FlightStatus\Load;

use Application\Lib\RateSeat\RestApiClient\Api\Base\Request\BaseRateSeatApiClientRequest;
use Application\Lib\RateSeatApi\RestApiClient\Api\GameSessions\Load\RateSeatApiClientRequestVo;
use Application\Utils\StringTemplateParserUtil;

/**
 * Class RateSeatApiClientRequest
 * @package Application\Lib\RateSeatApi\RestApiClient\Api\FlightStatus\Load
 */
class RateSeatApiClientRequest extends BaseRateSeatApiClientRequest
{

    const HTTP_METHOD = 'GET';

    const RESOURCE_URI_TEMPLATE = '/v1/operations/flightstatus/{{flightNumber}}/{{date}}?api_key={{apiToken}}';


    /*

    'method' => 'GET',
			'URI' => '/v1/offers/seatmaps/LH400/FRA/JFK/2014-12-15/Y?api_key=fk9qgddrt9uf4k7ug6w97xym',
			'data' => array(),

    */


    // =========== implement abstracts =============

    /**
     * @return RateSeatApiClientRequestVo
     */
    protected function createVo()
    {
        return new RateSeatApiClientRequestVo();
    }

    /**
     * @return $this
     */
    protected function parse()
    {

        $this->parseResourceUri();
    }

    /**
     * @return $this
     */
    protected function parseResourceUri()
    {
        $template = $this::RESOURCE_URI_TEMPLATE;

        $templateParsed = StringTemplateParserUtil::replaceMustaches(
            $template,
            array(
                'apiToken' => $this->getApiToken(),
                'flightNumber' => $this->getFlightNumber(),
                'date' => $this->getDate(),
            )
        );

        $this->resourceUri = $templateParsed;

        return $this;
    }







    // ============= override ============
    /**
     * @return RateSeatApiClientRequestVo
     */
    protected function getVo()
    {
        // just for proper type hinting in ide
        return parent::getVo();
    }



    // ============== custom ==============

    /**
     * @var string
     */
    private $apiToken;

    /**
     * @return string
     */
    private function getApiToken()
    {
        return $this->apiToken;
    }

    /**
     * @var string
     */
    private $flightNumber;

    /**
     * @return string
     */
    private function getFlightNumber()
    {
        return $this->flightNumber;
    }


    /**
     * @return string
     */
    private function getDate()
    {
        return $this->date;
    }


    /**
     * @param $apiToken
     * @param $flightNumber
     * @param $date
     * @param $curlData
     */
    public function __construct(
        $apiToken,
        $flightNumber,
        $date,
        $curlData
    )
    {
        $this->apiToken = $apiToken;
        $this->flightNumber = $flightNumber;
        $this->date = $date;
        $this->setCurlData($curlData);

        parent::__construct();
    }


}