<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/24/14
 * Time: 12:06 PM
 */

namespace Application\Api\Example\V1\RequestHandler\Test\Say;


use Application\Api\Base\Server\BaseRequestException as RequestException;
use Application\Api\Base\Server\BaseRequestVo;
use Application\Utils\ClassUtil;

/**
 * Class RequestVo
 *
 * @package Application\Api\Example\V1\RequestHandler\Test\Say
 */
class RequestVo extends BaseRequestVo
{

    const KEY_MESSAGE = 'message';

    // ======== implement abstracts =========

    /**
     * @return $this
     * @throws RequestException
     */
    public function validate()
    {
        $key = $this::KEY_MESSAGE;
        $value = $this->getMessage();
        $isValid = $value !== null;
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


    // ======== custom ========

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->getDataKey($this::KEY_MESSAGE);
    }


} 