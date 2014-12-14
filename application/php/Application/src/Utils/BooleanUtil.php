<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 10/15/13
 * Time: 2:54 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Utils;

/**
 * Class BooleanUtil
 *
 * @package Application\Utils
 */
class BooleanUtil
{

    /**
     * @param bool|int|string $value
     * @param mixed           $defaultValue
     *
     * @return bool|mixed
     */
    public static function castAsBool( $value, $defaultValue )
    {
        if ( is_bool( $value ) ) {

            return $value;
        }

        $trueValues = array( true, 'true', 1, '1' );
        if ( in_array( $value, $trueValues, true ) ) {

            return true;
        }

        $falseValues = array( false, 'false', 0, '0' );
        if ( in_array( $value, $falseValues, true ) ) {

            return false;
        }

        return $defaultValue;
    }

    /**
     * @param bool|int|string $value
     * @param string          $errorMessage
     *
     * @return bool
     * @throws \Exception
     */
    public static function castAndRequireBool( $value, $errorMessage )
    {
        $value = self::castAsBool( $value, null );
        if ( is_bool( $value ) ) {

            return $value;
        }

        throw new \Exception(
            'Invalid value! must be a bool type ! ' . $errorMessage
        );

    }


}