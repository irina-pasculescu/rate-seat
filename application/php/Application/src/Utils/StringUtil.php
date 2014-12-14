<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 5/30/13
 * Time: 10:28 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Utils;

/**
 * Class StringUtil
 *
 * @package Application\Utils
 */
class StringUtil
{


    /**
     * @param string $alphabet
     * @param int    $length
     *
     * @return string
     * @throws \Exception
     */
    public static function createRandomStringFromAlphabet( $alphabet, $length )
    {
        $isValid = is_string( $alphabet ) && ( !empty( $alphabet ) );
        if ( !$isValid ) {

            throw new \Exception( 'Invalid parameter "alphabet" !' . __METHOD__ );
        }
        $isValid = is_int( $length ) && ( $length > 0 );
        if ( !$isValid ) {

            throw new \Exception( 'Invalid parameter "length" !' . __METHOD__ );
        }

        $randomString = '';
        $charList     = str_split( $alphabet );
        if ( count( $charList ) < 0 ) {
            $charList[ ] = '';
        }
        $charsCount = count( $charList );
        shuffle( $charList );
        for ( $i = 0; $i < $length; $i++ ) {
            $index = rand( 0, ( $charsCount - 1 ) );
            $randomString .= (string)$charList[ $index ];
        }

        return $randomString;
    }


    /**
     * @param string $value
     * @param string $errorMessage
     *
     * @return string
     * @throws \Exception
     */
    public static function requireString(
        $value,
        $errorMessage
    )
    {
        $isValid = is_string( $value );
        if ( !$isValid ) {

            throw new \Exception(
                'Invalid value! must be string ! ' . $errorMessage
            );
        }

        return (string)$value;
    }

    /**
     * @param string $value
     * @param string $errorMessage
     *
     * @return string
     * @throws \Exception
     */
    public static function requireStringIsNotEmpty(
        $value,
        $errorMessage
    )
    {
        $isValid = is_string( $value )
                   && ( !self::isEmpty( $value ) );
        if ( !$isValid ) {

            throw new \Exception(
                'Invalid value! must be string, not empty ! ' . $errorMessage
            );
        }

        return (string)$value;
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public static function isEmpty( $value )
    {
        $result = true;
        if ( !is_string( $value ) ) {

            return $result;
        }

        return trim( $value ) === '';
    }

    /**
     * @param string $delimiter
     * @param array  $parts
     *
     * @return string
     */
    public static function joinStrictIfNotEmpty( $delimiter, $parts )
    {
        $result = '';
        if ( !is_array( $parts ) ) {

            return $result;
        }

        $finalParts = array();
        foreach ( $parts as $part ) {
            if ( !self::isEmpty( $part ) ) {
                $finalParts[ ] = $part;
            }
        }

        return (string)implode( $delimiter, $finalParts );
    }


    /**
     * @param string $text
     * @param int    $start
     * @param int    $length
     *
     * @return string
     * @throws \Exception
     */
    public static function cutUtf8( $text, $start, $length )
    {
        $text = (string)$text;
        if ( function_exists( 'mb_strcut' ) ) {

            return mb_strcut( $text, $start, $length, "UTF-8" );
        }

        throw new \Exception(
            'mbstring extension not installed! mb_strcut does not exist!'
        );


    }

}