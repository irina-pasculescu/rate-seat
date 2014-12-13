<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/8/14
 * Time: 4:26 PM
 */

namespace Application\Api\RateSeat\V1\Admin\RequestHandler\User\Load;


use Application\Api\Base\Server\BaseRequestException as RequestException;
use Application\Api\Base\Server\BaseRequestVo;
use Application\Definition\RateSeatApi\WhowModel\User\WhowUserIdType;
use Application\Utils\ClassUtil;


class RequestVo extends BaseRequestVo
{
    const KEY_USER_ID = 'userId';


    /*

   'Users::show' => array(
             'method' => 'GET',
             'URI' => '/users/{{userId}}',
             'payload' => '',
         )



     */


    // ======== implement abstracts =========

    /**
     * @return $this
     * @throws RequestException
     */
    public function validate()
    {
        $method = ClassUtil::getQualifiedMethodName($this, __METHOD__, true);

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
    public function getUserId()
    {
        $key = $this::KEY_USER_ID;
        $value = $this->getDataKey($key);

        return (string)WhowUserIdType::cast($value, '');
    }


}