<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 5/12/14
 * Time: 3:23 PM
 */

namespace Application\Definition\Couchbase;


use Application\Definition\BaseType;
use Application\Utils\ClassUtil;
use Application\Utils\StringUtil;


class CbViewStaleModeType extends BaseType
{


    const VALUE_FALSE = false;
    const VALUE_TRUE = true;
    const VALUE_UPDATE_AFTER = 'update_after';

    /**
     * @return array
     */
    public static function getValuesAllowed()
    {
        return array(
            static::VALUE_FALSE,
            static::VALUE_TRUE,
            static::VALUE_UPDATE_AFTER,
        );
    }


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
     * @return string|bool
     */
    public function getValue()
    {
        return parent::getValue();
    }


    /**
     * @param mixed $rawValue
     *
     * @return bool
     */
    public static function isValid($rawValue)
    {
        $value = static::cast($rawValue, null);
        $isValid = $value !== null;

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

        $valuesAllowed = static::getValuesAllowed();

        if ($value === 'ok') {
            $value = true;
        }
        if ($value === 'false') {
            $value = false;
        }


        if (!in_array($value, $valuesAllowed, true)) {

            return $defaultValue;
        }


        return $value;
    }


    /**
     * @return string
     */
    public static function createAllowedValuesErrorMessage()
    {
        return 'Allowed Values = ' . json_encode(
            static::getValuesAllowed()
        ) . ' !';
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
            . $this::createAllowedValuesErrorMessage()
            . ' !';


        $errorText = StringUtil::joinStrictIfNotEmpty(
            ' ',
            $messageList
        );

        return $errorText;
    }

} 