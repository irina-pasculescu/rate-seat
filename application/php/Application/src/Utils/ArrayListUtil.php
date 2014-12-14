<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 4/4/13
 * Time: 10:26 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Utils;

/**
 * Class ArrayListUtil
 *
 * @package Application\Utils
 */
class ArrayListUtil
{


    /**
     * @param array|null|mixed $array
     *
     * @return bool
     */
    public static function isArrayList( $array )
    {
        $result = false;

        if ( !is_array( $array ) ) {

            return $result;
        }

        // empty array?
        // --> we have an empty list type array or empty assoc array
        if ( count( $array ) < 1 ) {

            return true;
        }
        // no assoc array? --> we have a list type array
        if ( !ArrayAssocUtil::isAssocArray( $array ) ) {

            return true;
        }

        return $result;
    }

    /**
     * @param array|null|mixed $array
     *
     * @return bool
     */
    public static function isArrayListNotEmpty( $array )
    {
        $result = false;

        if ( !is_array( $array ) ) {

            return $result;
        }

        if ( count( $array ) < 1 ) {

            return false;
        }

        return self::isArrayList( $array );
    }


    /**
     * @param array|null $list
     *
     * @return array
     */
    public static function ensureList( $list )
    {
        $result = array();

        if ( !is_array( $list ) ) {

            return $result;
        }
        $newList = array_values( $list );
        if ( is_array( $newList ) ) {

            return $newList;
        }

        return $result;
    }


    /**
     * @param array|null $list
     * @param int        $offset
     * @param int|null   $length
     * @param bool       $ensureListEnabled
     *
     * @return array
     * @throws \Exception
     */
    public static function slice(
        $list,
        $offset,
        $length,
        $ensureListEnabled
    )
    {
        $result = array();

        if ( !is_bool( $ensureListEnabled ) ) {

            throw new \Exception(
                'Invalid parameter "ensureListEnabled". ' . __METHOD__
            );
        }

        if ( !is_int( $offset ) ) {

            throw new \Exception(
                'Invalid parameter "offset". ' . __METHOD__
            );
        }
        // offset can be positive or negative

        if ( $length !== null ) {
            $isValid = ( is_int( $length ) && ( $length >= 0 ) );
            if ( !$isValid ) {

                throw new \Exception(
                    'Invalid parameter "length". ' . __METHOD__
                );
            }
        }

        if ( !is_array( $list ) ) {

            return $result;
        }

        if ( $ensureListEnabled ) {
            $list = array_values( $list );
        }
        $result = array_slice( $list, $offset, $length, false );

        return $result;
    }

    /**
     * @param array|null $list
     * @param int        $offset
     * @param int|null   $length
     * @param bool       $ensureListEnabled
     *
     * @return array
     * @throws \Exception
     */
    public static function sliceFromLeft(
        $list,
        $offset,
        $length,
        $ensureListEnabled
    )
    {
        if ( !is_int( $offset ) ) {

            throw new \Exception(
                'Invalid parameter "offset". ' . __METHOD__
            );
        }
        // offset must be positive
        if ( $offset < 0 ) {
            $offset = ( -1 ) * $offset;
        }

        return self::slice( $list, $offset, $length, $ensureListEnabled );
    }

    /**
     * @param array|null $list
     * @param int        $offset
     * @param int|null   $length
     * @param bool       $ensureListEnabled
     *
     * @return array
     * @throws \Exception
     */
    public static function sliceFromRight(
        $list,
        $offset,
        $length,
        $ensureListEnabled
    )
    {
        if ( !is_int( $offset ) ) {

            throw new \Exception(
                'Invalid parameter "offset". ' . __METHOD__
            );
        }
        // offset must be negative
        if ( $offset > 0 ) {
            $offset = ( -1 ) * $offset;
        }

        return self::slice( $list, $offset, $length, $ensureListEnabled );
    }

    /**
     * @param array|null $sourceList
     * @param array|null $appendList
     * @param bool       $ensureListEnabled
     *
     * @return array
     * @throws \Exception
     */
    public static function appendList(
        $sourceList,
        $appendList,
        $ensureListEnabled
    )
    {

        $result = array();

        if ( !is_bool( $ensureListEnabled ) ) {

            throw new \Exception(
                'Invalid parameter "ensureListEnabled". ' . __METHOD__
            );
        }

        if ( !is_array( $sourceList ) ) {
            $sourceList = array();
        }
        if ( !is_array( $appendList ) ) {
            $appendList = array();
        }

        if ( $ensureListEnabled ) {

            $sourceList = array_values( $sourceList );
            $appendList = array_values( $appendList );
        }

        $resultList = array_merge( $sourceList, $appendList );
        if ( is_array( $resultList ) ) {

            return $resultList;
        }

        return $result;
    }


}