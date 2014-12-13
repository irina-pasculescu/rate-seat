<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 5/9/14
 * Time: 2:00 PM
 */

namespace Application\Definition;

/**
 * Class FloatType
 *
 * @package Application\Definition
 */
class FloatType extends BaseType
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
     * @return float
     */
    public function getValue()
    {
        return (float)parent::getValue();
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
     * @return float|mixed
     */
    public static function cast($value, $defaultValue)
    {
        if ($value instanceof BaseType) {
            $value = $value->getValue();
        }

        if (is_float($value)) {

            return (float)$value;
        }
        if (is_int($value)) {

            return (float)$value;
        }

        // values<0
        if (is_string($value)) {
            $valueFiltered = filter_var($value, FILTER_VALIDATE_FLOAT);
            if (is_float($valueFiltered)) {

                return (float)$valueFiltered;
            }
            if (is_int($valueFiltered)) {

                return (float)$valueFiltered;
            }
        }


        return $defaultValue;
    }


}