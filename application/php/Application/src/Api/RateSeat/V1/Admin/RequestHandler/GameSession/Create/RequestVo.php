<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/8/14
 * Time: 4:26 PM
 */

namespace Application\Api\RateSeat\V1\Admin\RequestHandler\GameSession\Create;



use Application\Api\Base\Server\BaseRequestException as RequestException;
use Application\Api\Base\Server\BaseRequestVo;
use Application\Definition\RateSeatApi\WhowModel\Game\WhowGameIdType;
use Application\Definition\RateSeatApi\WhowModel\User\WhowUserIdType;
use Application\Utils\ClassUtil;

class RequestVo extends BaseRequestVo
{
    const KEY_USER_ID = 'userId';
    const KEY_GAME_ID = 'gameId';

    /*

    /*

     'GameSessions::create' => array(
             'method' => 'POST',
             'URI' => '/game_sessions',
             'payload' => array(
                 'userId' => '53fc9eb31b4d5eef118b4569',
                 'gameId' => '53e1de27499a9faa0d8b4567',
             ),
         ),

     */


    // ======== implement abstracts =========

    /**
     * @return $this
     * @throws RequestException
     */
    public function validate()
    {
        $method = ClassUtil::getQualifiedMethodName($this, __METHOD__, true);

        $key = $this::KEY_GAME_ID;
        $value = $this->getGameId();
        if (empty($value)) {

            throw new RequestException(
                'Invalid request.' . $key . ' !'
                . ' (' . $method . ')'
            );
        }

        $key = $this::KEY_USER_ID;
        $value = $this->getUserId();
        if (empty($value)) {

            throw new RequestException(
                'Invalid request.' . $key . ' !'
                . ' (' . $method . ')'
            );
        }

        return $this;
    }


    // ======== custom ========

    /**
     * @return string
     */
    public function getGameId()
    {
        $key = $this::KEY_GAME_ID;
        $value = $this->getDataKey($key);

        return (string)WhowGameIdType::cast($value, '');
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        $key = $this::KEY_USER_ID;
        $value = $this->getDataKey($key);

        return (string)WhowUserIdType::cast($value, '');
    }

} 