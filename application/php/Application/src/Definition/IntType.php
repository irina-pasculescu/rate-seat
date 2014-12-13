<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 10/23/13
 * Time: 9:20 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Definition;


/**
 * Class IntType
 *
 * @package Application\Definition
 */
class IntType extends BaseType
{

    /**
     * @param int|string $rawValue
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
     * @return int
     */
    public function getValue()
    {
        return (int)parent::getValue();
    }


    /**
     * @param int|string|mixed $rawValue
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
     * @param mixed $value
     * @param mixed $defaultValue
     *
     * @return int|mixed
     */
    public static function cast($value, $defaultValue)
    {
        if ($value instanceof BaseType) {
            $value = $value->getValue();
        }

        if (is_int($value)) {

            return (int)$value;
        }

        // values<0
        if (is_string($value)) {
            $valueFiltered = filter_var($value, FILTER_VALIDATE_INT);
            if (
                is_int($valueFiltered)
                && (string)$valueFiltered === (string)$value
            ) {
                $value = $valueFiltered;

                return (int)$value;
            }
        }


        return $defaultValue;
    }


}