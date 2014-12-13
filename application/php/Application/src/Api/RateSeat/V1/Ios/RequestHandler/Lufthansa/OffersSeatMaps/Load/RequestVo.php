<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/8/14
 * Time: 4:26 PM
 */

namespace Application\Api\RateSeat\V1\Ios\RequestHandler\Lufthansa\OffersSeatMaps\Load;


use Application\Api\Base\Server\BaseRequestException as RequestException;
use Application\Api\Base\Server\BaseRequestVo;
use Application\Definition\RateSeatApi\WhowModel\Session\SessionTokenType;
use Application\Utils\ClassUtil;


class RequestVo extends BaseRequestVo
{
    const KEY_SESSION_TOKEN = 'sessionToken';


    /*

    /*

    'GameSessions::get' => array(
             'method' => 'POST',
             'URI' => '/game_sessions/action/get/{{sessionToken}}',
             'payload' => array(),
         ),




     */


    // ======== implement abstracts =========

    /**
     * @return $this
     * @throws RequestException
     */
    public function validate()
    {
        $this->validateSessionToken();

        return $this;
    }



    // ======== getters ========

    /**
     * @return string
     */
    public function getSessionToken()
    {
        $key = $this::KEY_SESSION_TOKEN;
        $value = $this->getDataKey($key);

        return (string)SessionTokenType::cast($value, '');
    }

    // ============= validators ==========

    /**
     * @return $this
     * @throws RequestException
     */
    private function validateSessionToken()
    {
        $method = ClassUtil::getQualifiedMethodName($this, __METHOD__, true);

        $key = $this::KEY_SESSION_TOKEN;
        $value = $this->getSessionToken();
        if (empty($value)) {

            throw new RequestException(
                'Invalid request.' . $key . ' !'
                . ' (' . $method . ')'
            );
        }

        return $this;
    }

} 