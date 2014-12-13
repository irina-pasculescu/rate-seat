<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 10/23/13
 * Time: 9:50 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Definition;


/**
 * Class StringStrictType
 *
 * @package Application\Definition
 */
class StringStrictType extends BaseType
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
    public static function isValid($rawValue)
    {
        $value = self::cast($rawValue, null);
        $isValid = is_string($value);

        return $isValid;
    }

    /**
     * @param mixed $value
     * @param mixed $defaultValue
     *
     * @return mixed|string
     */
    public static function cast($value, $defaultValue)
    {
        if ($value instanceof BaseType) {
            $value = $value->getValue();
        }

        if (is_string($value)) {

            return (string)$value;
        }

        return $defaultValue;
    }


}