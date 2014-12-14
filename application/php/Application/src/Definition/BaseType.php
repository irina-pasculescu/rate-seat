<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 10/23/13
 * Time: 9:09 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Definition;

use Application\Utils\ClassUtil;
use Application\Utils\StringUtil;

/**
 * Class BaseType
 *
 * @package Application\Definition
 */
class BaseType
{
    /**
     * @var null
     */
    protected $value = null;
    /**
     * @var null
     */
    protected $rawValue = null;

    /**
     * @param mixed  $rawValue
     * @param string $errorMessage
     *
     * @throws \InvalidArgumentException
     */
    public function __construct( $rawValue, $errorMessage = '' )
    {
        $errorText = StringUtil::joinStrictIfNotEmpty(
            ' ',
            array(
                $errorMessage,
                'Invalid value! Unable to cast as '
                . ClassUtil::getClassNameAsJavaStyle( $this ) . ' !'
            )
        );

        throw new \InvalidArgumentException( $errorText );
    }

    /**
     * @return null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return mixed
     */
    public function getRawValue()
    {
        return $this->rawValue;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->getValue();
    }

    /**
     * @param mixed $rawValue
     *
     * @return bool
     */
    public static function isValid( $rawValue )
    {
        return false;
    }

    /**
     * @param $value
     * @param $defaultValue
     *
     * @return mixed
     */
    public static function cast( $value, $defaultValue )
    {
        return $defaultValue;
    }


    /**
     * @param mixed  $value
     * @param mixed  $rawValue
     * @param string $errorDetailsText
     *
     * @return string
     */
    protected function createUnableToCastExceptionMessage(
        $value,
        $rawValue,
        $errorDetailsText
    )
    {

        $messageList = array(
            $errorDetailsText,
            'Invalid value',

        );

        try {
            if ( is_scalar( $rawValue ) ) {
                $messageList[ ] = '(type ' . gettype( $rawValue ) . ') !';
            }
            else {
                if ( is_resource( $messageList ) ) {
                    $messageList[ ] = '(type resource) !';
                }
                else {
                    $messageList[ ] = '(type '
                                      . ClassUtil::getClassNameAsJavaStyle( $rawValue ) . ') !';
                }
            }

        }
        catch (\Exception $e) {
            // nop
        }

        $messageList[ ] = 'Unable to cast as '
                          . ClassUtil::getClassNameAsJavaStyle( $this ) . ' !';


        $errorText = StringUtil::joinStrictIfNotEmpty(
            ' ',
            $messageList
        );

        return $errorText;
    }

}