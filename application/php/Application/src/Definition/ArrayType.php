<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 2/24/14
 * Time: 4:54 PM
 */

namespace Application\Definition;

/**
 * Class ArrayType
 *
 * @package Application\Definition
 */
class ArrayType extends BaseType
{

    /**
     * @param mixed $rawValue
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
     * @param mixed $rawValue
     *
     * @return bool
     */
    public static function isValid($rawValue)
    {
        $value = self::cast($rawValue, null);
        $isValid = is_array($value);

        return $isValid;
    }

    /**
     * @param mixed $value
     * @param mixed $defaultValue
     *
     * @return array|mixed
     */
    public static function cast($value, $defaultValue)
    {
        if ($value instanceof BaseType) {
            $value = $value->getValue();
        }

        if (is_array($value)) {

            return (array)$value;
        }

        return $defaultValue;
    }

} 