<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/24/14
 * Time: 12:08 PM
 */

namespace Application\Api\Example\V1\RequestHandler\Test\GetDate;

use Application\Api\Base\Server\BaseResponseVo;

/**
 * Class ResponseVo
 *
 * @package Application\Api\Example\V1\RequestHandler\Test\GetDate
 */
class ResponseVo extends BaseResponseVo
{

    // ========= custom ===========

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setRequestTimestamp($value)
    {
        $this->setDataKey('requestTimestamp', $value);

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setRequestDate($value)
    {
        $this->setDataKey('requestDate', $value);

        return $this;
    }

    /**
     * @param float $value
     *
     * @return $this
     */
    public function setRequestMicroTimestamp($value)
    {
        $this->setDataKey('requestMicroTimestamp', $value);

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setDateUtc($value)
    {
        $this->setDataKey('dateUtc', $value);

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setDateLocal($value)
    {
        $this->setDataKey('dateLocal', $value);

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setDate($value)
    {
        $this->setDataKey('date', $value);

        return $this;
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setDateTimestamp($value)
    {
        $this->setDataKey('dateTimestamp', $value);

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setDateTimezoneLocal($value)
    {
        $this->setDataKey('dateTimezoneLocal', $value);

        return $this;
    }


}