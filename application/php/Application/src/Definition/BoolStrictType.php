<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 11/6/14
 * Time: 1:43 PM
 */

namespace Application\Definition;


use Application\Utils\ClassUtil;
use Application\Utils\StringUtil;

class BoolStrictType extends BaseType
{

    const VALUE_TRUE = true;
    const VALUE_FALSE = false;

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
    public static function getValuesAllowed()
    {
        return array(
            self::VALUE_TRUE,
            self::VALUE_FALSE,
        );
    }


    /**
     * @param mixed $value
     * @param mixed $rawValue
     * @param string $errorDetailsText
     *
     * @return string
     */
    protected function createUnableToCastExceptionMessage(
        $value,
        $rawValue,
        $errorDetailsText
    ) {

        $messageList = array(
            $errorDetailsText,
            'Invalid value',

        );

        try {
            if (is_scalar($rawValue)) {
                $messageList[] = '(type ' . gettype($rawValue) . ') !';
            } else {
                if (is_resource($messageList)) {
                    $messageList[] = '(type resource) !';
                } else {
                    $messageList[] = '(type '
                        . ClassUtil::getClassNameAsJavaStyle($rawValue) . ') !';
                }
            }

        } catch (\Exception $e) {
            // nop
        }

        $messageList[] = 'Unable to cast as '
            . ClassUtil::getClassNameAsJavaStyle($this)
            . ' allowedValues=' . json_encode($this::getValuesAllowed())
            . ' !';


        $errorText = StringUtil::joinStrictIfNotEmpty(
            ' ',
            $messageList
        );

        return $errorText;
    }

    /**
     * @return bool|null
     */
    public function getValue()
    {
        return parent::getValue() === true;
    }


    /**
     * @param mixed $rawValue
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
     * @param $value
     * @param $defaultValue
     *
     * @return bool|string|mixed
     */
    public static function cast($value, $defaultValue)
    {
        if ($value instanceof BaseType) {
            $value = $value->getValue();
        }


        $valuesAllowed = self::getValuesAllowed();

        if (!in_array($value, $valuesAllowed, true)) {

            return $defaultValue;
        }


        return $value;
    }

} 