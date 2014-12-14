<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/8/14
 * Time: 4:38 PM
 */

namespace Application\Definition;

/**
 * Class StringStrictAlphaNumericTypeNotEmpty
 * @package Application\Definition
 */
class StringStrictAlphaNumericTypeNotEmpty extends StringStrictAlphaNumericType
{
    /**
     * @param mixed  $rawValue
     * @param string $errorMessage
     *
     * @throws \InvalidArgumentException
     */
    public function __construct( $rawValue, $errorMessage = '' )
    {
        parent::__construct( $rawValue, $errorMessage );
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return (string)parent::getValue();
    }

    /**
     * @param mixed $rawValue
     *
     * @return bool
     */
    public static function isValid( $rawValue )
    {
        $value   = self::cast( $rawValue, null );
        $isValid = $value !== null;

        return $isValid;
    }

    /**
     * @param mixed $value
     * @param mixed $defaultValue
     *
     * @return mixed|string
     */
    public static function cast( $value, $defaultValue )
    {
        $value = parent::cast( $value, null );
        if ( $value === null ) {

            return $defaultValue;
        }

        $isValid = is_string( $value )
                   && ctype_alnum( $value )
                   && trim( $value ) !== '';

        if ( $isValid ) {

            return (string)$value;
        }

        return $defaultValue;
    }
}