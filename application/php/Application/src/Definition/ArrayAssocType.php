<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 2/25/14
 * Time: 7:38 AM
 */

namespace Application\Definition;

use Application\Utils\ArrayAssocUtil;


/**
 * Class ArrayAssocType
 *
 * @package Application\Definition
 */
class ArrayAssocType extends ArrayType
{

    /**
     * @param bool|int|string $rawValue
     * @param string $errorMessage
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($rawValue, $errorMessage = '')
    {
        $value = $this::cast($rawValue, null);
        $isValid = $this::isValid($value);
        if (!$isValid) {

            throw new \InvalidArgumentException(
                $this->createUnableToCastExceptionMessage(
                    $value,
                    $rawValue,
                    $errorMessage
                )
            );

        }

        $this->value = $value;
        if ($rawValue instanceof BaseType) {
            $this->rawValue = $rawValue->getValue();
        } else {
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
    public static function isValid($rawValue)
    {
        $value = self::cast($rawValue, null);
        $isValid = $value !== null;

        return $isValid;
    }

    /**
     * @param array|null|mixed $value
     * @param mixed $defaultValue
     *
     * @return array|mixed
     */
    public static function cast($value, $defaultValue)
    {
        if ($value instanceof BaseType) {
            $value = $value->getValue();
        }


        if (ArrayAssocUtil::isAssocArray($value)) {

            return (array)$value;
        }

        return $defaultValue;
    }
} 