<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/8/14
 * Time: 4:26 PM
 */

namespace Application\Api\RateSeat\V1\Admin\RequestHandler\User\Wallet\Increase;


use Application\Api\Base\Server\BaseRequestException as RequestException;
use Application\Api\Base\Server\BaseRequestVo;
use Application\Definition\StringStrictNotEmptyType;
use Application\Definition\UintTypeNotEmpty;
use Application\Definition\RateSeatApi\WhowModel\User\WhowUserIdType;
use Application\Utils\ClassUtil;


class RequestVo extends BaseRequestVo
{
    const KEY_USER_ID = 'userId';
    const KEY_CURRENCY = 'currency';
    const KEY_AMOUNT = 'amount';
    const KEY_REASON = 'reason';


    /*

   'Users::increaseWallet' => array(
             'method' => 'POST',
             'URI' => '/users/action/increaseWallet/{{userId}}',
             'payload' => array(
                 'currency' => 'chips',
                 'amount' => 1250,
                 'reason' => 'cURL test booking'
             )
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

        $key = $this::KEY_USER_ID;
        $value = $this->getUserId();
        if (empty($value)) {

            throw new RequestException(
                'Invalid request.' . $key . ' !'
                . ' (' . $method . ')'
            );
        }

        $key = $this::KEY_CURRENCY;
        $value = $this->getCurrency();
        if (empty($value)) {

            throw new RequestException(
                'Invalid request.' . $key . ' !'
                . ' (' . $method . ')'
            );
        }

        $key = $this::KEY_AMOUNT;
        $value = $this->getAmount();
        if (empty($value)) {

            throw new RequestException(
                'Invalid request.' . $key . ' !'
                . ' (' . $method . ')'
            );
        }

        $key = $this::KEY_REASON;
        $value = $this->getReason();
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

    /**
     * @return string
     */
    public function getCurrency()
    {
        $key = $this::KEY_CURRENCY;
        $value = $this->getDataKey($key);

        return (string)WhowUserIdType::cast($value, '');
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        $key = $this::KEY_AMOUNT;
        $value = $this->getDataKey($key);

        return (int)UintTypeNotEmpty::cast($value, 0);
    }

    /**
     * @return string
     */
    public function getReason()
    {
        $key = $this::KEY_REASON;
        $value = $this->getDataKey($key);

        return (string)StringStrictNotEmptyType::cast($value, '');
    }


} 