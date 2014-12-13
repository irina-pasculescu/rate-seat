<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 9/17/13
 * Time: 3:24 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Lib\Rpc\JsonRpc\Utils;

/**
 * Class JsonEncoderUtil
 *
 * @package Application\Lib\Rpc\JsonRpc\Utils
 */
class JsonEncoderUtil
{

    /**
     * @param mixed $value
     * @param bool $delegateExceptions
     *
     * @return string|null
     * @throws \Exception
     */
    public static function encode($value, $delegateExceptions)
    {
        $result = null;
        $delegateExceptions = ($delegateExceptions === true);
        $text = null;
        try {
            $text = json_encode($value);
        } catch (\Exception $e) {
            if ($delegateExceptions) {

                throw $e;
            }
        }

        if (!is_string($text)) {

            if (!$delegateExceptions) {

                return $result;
            }

            throw new \Exception('json encode failed! invalid result.');
        }

        return $text;
    }

    /**
     * @param string $text
     * @param bool $assoc
     * @param bool $delegateExceptions
     *
     * @return mixed|null
     * @throws \Exception
     */
    public static function decode($text, $assoc, $delegateExceptions)
    {
        $result = null;
        $assoc = ($assoc === true);
        $delegateExceptions = ($delegateExceptions === true);

        if (!is_string($text)) {

            if (!$delegateExceptions) {

                return $result;
            }

            throw new \Exception(
                'json decode failed! parameter "text" must be a string!'
            );
        }

        $value = null;
        try {
            $value = json_decode($text, $assoc);
        } catch (\Exception $e) {
            if (!$delegateExceptions) {

                return $result;
            }

            throw $e;
        }


        if ($value !== null) {

            return $value;
        }

        $isValid = strtolower(trim($text)) === 'null';
        if ($isValid) {

            return $value;
        }

        if (!$delegateExceptions) {

            return $result;
        }

        throw new \Exception('json decode failed! invalid result.');

    }

}