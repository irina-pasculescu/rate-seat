<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 10/23/13
 * Time: 9:32 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Definition;


use Application\Utils\ClassUtil;
use Application\Utils\StringUtil;

/**
 * Class BoolType
 * @package Application\Definition
 */
class BoolType extends BaseType
{

    /**
     * @param bool|int|string $rawValue
     * @param string          $errorMessage
     *
     * @throws \InvalidArgumentException
     */
    public function __construct( $rawValue, $errorMessage = '' )
    {
        $value   = self::cast( $rawValue, null );
        $isValid = is_bool( $value );
        if ( !$isValid ) {

            $errorText = StringUtil::joinStrictIfNotEmpty(
                ' ',
                array(
                    $errorMessage,
                    'Invalid value! Unable to cast as '
                    . ClassUtil::getClassNameAsJavaStyle( $this ) . ' !'
                )
            );

            throw new \InvalidArgumentException( $errorText );

        }
        $this->value    = $value;
        $this->rawValue = $rawValue;
    }

    /**
     * @return bool
     */
    public function getValue()
    {
        return parent::getValue() === true;
    }


    /**
     * @param bool|int|string|mixed $rawValue
     *
     * @return bool
     */
    public static function isValid( $rawValue )
    {
        $value   = self::cast( $rawValue, null );
        $isValid = is_bool( $value );

        return $isValid;
    }

    /**
     * @param bool|int|string $value
     * @param mixed           $defaultValue
     *
     * @return bool|mixed
     */
    public static function cast( $value, $defaultValue )
    {
        $result = $defaultValue;

        if ( is_bool( $value ) ) {

            return ( $value === true );
        }

        $trueValues = array( 1, '1', true, 'true' );
        if ( in_array( $value, $trueValues, true ) ) {

            return true;
        }

        $falseValues = array( 0, '0', false, 'false' );
        if ( in_array( $value, $falseValues, true ) ) {

            return false;
        }

        return $result;
    }


}