<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 5/9/14
 * Time: 2:13 PM
 */

namespace Application\Definition;

/**
 * Class UfloatTypeNotEmpty
 * @package Application\Definition
 */
class UfloatTypeNotEmpty extends UintType
{

    /**
     * @param int|float|string $rawValue
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
     * @param int|float|string|mixed $rawValue
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
     * @param int|float|string $value
     * @param mixed $defaultValue
     *
     * @return float|mixed
     */
    public static function cast($value, $defaultValue)
    {
        if ($value instanceof BaseType) {
            $value = $value->getValue();
        }

        // cast as int
        $value = UfloatType::cast($value, null);
        $isValid = is_float($value) && $value > 0;

        if ($isValid) {

            return (float)$value;
        }

        return $defaultValue;
    }


} 