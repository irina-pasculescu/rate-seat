<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 5/21/14
 * Time: 8:20 AM
 */

namespace Application\Definition;

/**
 * Class ArrayListNotEmptyType
 *
 * @package Application\Definition
 */
class ArrayListNotEmptyType extends ArrayListType
{


    /**
     * @param mixed $value
     * @param mixed $defaultValue
     *
     * @return array|mixed
     */
    public static function cast($value, $defaultValue)
    {
        $value = parent::cast($value, null);

        if (!is_array($value)) {

            return $defaultValue;
        }

        if (count($value) > 0) {

            return (array)$value;
        }


        return $defaultValue;
    }
} 