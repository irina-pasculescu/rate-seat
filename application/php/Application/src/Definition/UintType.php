<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 10/23/13
 * Time: 9:16 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Definition;


/**
 * Class UintType
 *
 * @package Application\Definition
 */
class UintType extends IntType
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
     * @param int|string $value
     * @param mixed $defaultValue
     *
     * @return int|mixed
     */
    public static function cast($value, $defaultValue)
    {
        if ($value instanceof BaseType) {
            $value = $value->getValue();
        }

        // cast as int
        $value = IntType::cast($value, null);
        $isValid = is_int($value) && $value >= 0;

        if ($isValid) {

            return (int)$value;
        }

        return $defaultValue;
    }

}