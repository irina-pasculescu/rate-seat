<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/24/14
 * Time: 12:06 PM
 */

namespace Application\Api\Example\V1\RequestHandler\Test\GetDate;


use Application\Api\Base\Server\BaseRequestException as RequestException;
use Application\Api\Base\Server\BaseRequestVo;
use Application\Utils\ClassUtil;

/**
 * Class RequestVo
 *
 * @package Application\Api\Example\V1\RequestHandler\Test\GetDate
 */
class RequestVo extends BaseRequestVo
{


    const KEY_DATE = 'date';

    // ======== implement abstracts =========

    /**
     * @return $this
     * @throws RequestException
     */
    public function validate()
    {
        $key = $this::KEY_DATE;
        $value = $this->getDate();
        $isValid = ($value === null)
            || (is_int($value) && $value >= 0)
            || (is_string($value)) && ($value !== '');
        if (!$isValid) {

            throw new RequestException(
                'Invalid request.' . $key . ' !'
                . ' ' . ClassUtil::getQualifiedMethodName(
                    $this,
                    __METHOD__,
                    true
                )
            );
        }

        return $this;
    }


    // ========= custom ========
    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->getDataKey($this::KEY_DATE);
    }


}