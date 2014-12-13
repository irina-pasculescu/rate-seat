<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 8/14/12
 * Time: 4:10 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Utils;

/**
 * Class ArrayAssocUtil
 *
 * @package Application\Utils
 */
class ArrayAssocUtil
{

    /**
     * @param array|null|mixed $array
     * @param array|null|mixed $defaultKeyValueMap
     *
     * @return array
     */
    public static function ensureArray($array, $defaultKeyValueMap)
    {
        if (!is_array($array)) {
            $array = array();
        }

        if (!is_array($defaultKeyValueMap)) {
            $defaultKeyValueMap = array();
        }

        foreach ($defaultKeyValueMap as $key => $value) {
            if (!array_key_exists($key, $array)) {
                $array[$key] = $value;
            }
        }

        return $array;
    }


    /**
     * @param array $sourceArray
     * @param array $targetArray
     * @param array $preserveKeysList
     *
     * @return array
     */
    public static function mixinOverride(
        $sourceArray,
        $targetArray,
        $preserveKeysList
    ) {

        if (!is_array($sourceArray)) {
            $sourceArray = array();
        }

        $result = (array)$sourceArray;

        if (!is_array($targetArray)) {
            $targetArray = array();
        }
        if (!is_array($preserveKeysList)) {
            $preserveKeysList = array();
        }

        foreach ($targetArray as $key => $value) {

            if (!in_array($key, $preserveKeysList, true)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * @param array $sourceArray
     * @param array $targetArrayList
     * @param array $preserveKeysList
     *
     * @return array
     */
    public static function mixinOverrideMulti(
        $sourceArray,
        $targetArrayList,
        $preserveKeysList
    ) {

        if (!is_array($sourceArray)) {
            $sourceArray = array();
        }

        $result = (array)$sourceArray;

        if (!is_array($preserveKeysList)) {
            $preserveKeysList = array();
        }

        foreach ($targetArrayList as $targetArray) {
            if (!is_array($targetArray)) {

                continue;
            }
            foreach ($targetArray as $key => $value) {

                if (!in_array($key, $preserveKeysList, true)) {
                    $result[$key] = $value;
                }
            }

        }

        return $result;
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isAssocArray($value)
    {
        $result = false;

        if (!is_array($value)) {

            return $result;
        }

        if (count(array_keys($value)) < 1) {
            // empty array
            return true;
        }

        $isAssocArray = (array_keys($value)
            !== range(0, count($value) - 1)
        );

        return $isAssocArray;
    }


    /**
     * removes all the keys from array that are not white listed in keysList
     *
     * @param array $array
     * @param array $keysList
     *
     * @return array
     */
    public static function keepKeys($array, $keysList)
    {
        if (!is_array($array)) {
            $array = array();
        }

        if (!is_array($keysList)) {
            $keysList = array();
        }

        $result = array();
        foreach ($array as $key => $value) {
            if (in_array($key, $keysList, true)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * removes all the keys from array that are in keysList
     *
     * @param array $array
     * @param array $keysList
     *
     * @return array
     */
    public static function removeKeys($array, $keysList)
    {
        if (!is_array($array)) {
            $array = array();
        }

        if (!is_array($keysList)) {
            $keysList = array();
        }

        $result = array();
        foreach ($array as $key => $value) {
            if (!in_array($key, $keysList, true)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * @param array $array
     * @param array $keysList
     *
     * @return array
     */
    public static function extractKeys($array, $keysList)
    {
        $result = array();
        if (!is_array($array)) {
            $array = array();
        }
        if (!is_array($keysList)) {
            $keysList = array();
        }
        foreach ($keysList as $key) {
            $value = null;
            if (array_key_exists($key, $array)) {
                $value = $array[$key];
            }

            $result[$key] = $value;
        }

        return $result;
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isAssocArrayNotEmpty($value)
    {
        $result = false;

        if (!is_array($value)) {

            return $result;
        }

        if (count($value) < 1) {

            return $result;
        }

        return self::isAssocArray($value);
    }

    /**
     * @param array|null|mixed $array
     * @param string $key
     *
     * @return bool
     */
    public static function hasKey($array, $key)
    {
        $result = false;

        if (!is_array($array)) {

            return $result;
        }

        return array_key_exists($key, $array);
    }

    /**
     * @param array|object|null|mixed $obj
     *
     * @return array
     */
    public static function objectToArrayRecursive($obj)
    {
        $result = self::makeObjectToArrayRecursive($obj);
        if (!is_array($result)) {
            $result = array();
        }

        return (array)$result;
    }

    /**
     * @param $obj |array|null|mixed
     *
     * @return array|mixed
     */
    private static function makeObjectToArrayRecursive($obj)
    {
        if (is_object($obj)) {
            $objVars = (array)get_object_vars($obj);
            $obj = $objVars;
        }

        if (is_array($obj)) {
            $new = array();
            foreach ($obj as $key => $val) {
                $new[$key] = self::objectToArrayRecursive($val);
            }
        } else {
            $new = $obj;
        }

        return $new;
    }

    /**
     * @param array|null $array
     * @param string $name
     *
     * @return null|mixed
     */
    public static function getProperty($array, $name)
    {
        if (!is_array($array)) {

            return null;
        }

        if (array_key_exists($name, $array)) {

            return $array[$name];
        }

        return null;
    }

    /**
     * @param array|mixed $array
     * @param string $name
     * @param mixed $value
     *
     * @return array
     */
    public static function setProperty($array, $name, $value)
    {
        if (!is_array($array)) {
            $array = array();
        }

        $array[$name] = $value;

        return $array;
    }


    /**
     * @param $array
     * @param $keysList
     * @param $defaultValue
     *
     * @return array
     */
    public static function keepAndEnsureKeys($array, $keysList, $defaultValue)
    {
        if (!is_array($keysList)) {
            $keysList = array();
        }

        $defaultMap = array();
        foreach ($keysList as $key) {
            $defaultMap[$key] = $defaultValue;
        }

        $array = self::ensureArray($array, $defaultMap);

        return self::keepKeys($array, $keysList);
    }

}