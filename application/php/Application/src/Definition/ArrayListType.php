<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 5/14/14
 * Time: 5:04 PM
 */

namespace Application\Definition;


use Application\Utils\ArrayListUtil;


/**
 * Class ArrayListType
 *
 * @package Application\Definition
 */
class ArrayListType extends ArrayType
{

    /**
     * @param bool|int|string $rawValue
     * @param string          $errorMessage
     *
     * @throws \InvalidArgumentException
     */
    public function __construct( $rawValue, $errorMessage = '' )
    {
        $value   = $this::cast( $rawValue, null );
        $isValid = $this::isValid( $value );
        if ( !$isValid ) {

            throw new \InvalidArgumentException(
                $this->createUnableToCastExceptionMessage(
                    $value,
                    $rawValue,
                    $errorMessage
                )
            );

        }

        $this->value = $value;
        if ( $rawValue instanceof BaseType ) {
            $this->rawValue = $rawValue->getValue();
        }
        else {
            $this->rawValue = $rawValue;
        }
    }

    /**
     * @return array
     */
    public function getValue()
    {
        return (array)parent::getValue();
    }


    /**
     * @param bool|int|string|mixed $rawValue
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
     * @param array|null|mixed $value
     * @param mixed            $defaultValue
     *
     * @return array|mixed
     */
    public static function cast( $value, $defaultValue )
    {
        if ( $value instanceof BaseType ) {
            $value = $value->getValue();
        }

        $isValid = ArrayListUtil::isArrayList( $value );

        if ( $isValid ) {

            return (array)$value;
        }

        return $defaultValue;
    }
} 