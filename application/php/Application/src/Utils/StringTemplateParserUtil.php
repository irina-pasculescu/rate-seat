<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 3/13/13
 * Time: 10:30 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Utils;

/**
 * Class StringTemplateParserUtil
 *
 * @package Application\Utils
 */
class StringTemplateParserUtil
{

    /**
     * @param array $array
     * @param array $replace
     *
     * @return array
     * @throws \Exception
     */
    public static function replaceMustachesInAssocArrayItems($array, $replace)
    {
        if (!is_array($array)) {

            throw new \Exception('Invalid parameter "array". ' . __METHOD__);
        }

        $result = array();

        foreach ($array as $key => $value) {

            if (is_string($value)) {
                $value = self::replaceMustaches($value, $replace);
            }
            $result[$key] = $value;
        }

        return $result;
    }

    /**
     * @param string $text
     * @param array|null $replace
     *
     * @return string
     * @throws \Exception
     */
    public static function replaceMustaches($text, $replace)
    {
        $prefixDelimiter = '{{';
        $suffixDelimiter = '}}';

        if (!is_string($text)) {

            throw new \Exception('Invalid parameter "text". ' . __METHOD__);
        }

        $result = (string)$text;

        if ($replace === null) {

            return $result;
        }
        if (!is_array($replace)) {

            throw new \Exception(
                'Invalid parameter "replace".'
                . ' Must be array or null '
                . __METHOD__
            );
        }

        $replaceNew = array();
        foreach ($replace as $key => $value) {
            $newKey = $prefixDelimiter . (string)$key . $suffixDelimiter;
            $replaceNew[$newKey] = $value;
        }
        $replace = $replaceNew;

        $result = self::replace($text, $replace);

        return $result;
    }


    /**
     * @see    : http://www.php.net/manual/en/function.strtr.php#106282
     *
     * THIS METHOD IS SO AWESOME. IT PROTECTS FROM NESTED TEMPLATES
     *
     * @Example:
     * $template = "INSERT INTO table3={{table3}} table2={{table2}} table1={{table1}} table3={{table3}} table={{table}} FOO table={{table}} BAR table table2={{table2}} table3={{table3}}";
     * $result = replace(
     *    $template,
     *      array(
     * "      {{table}}" => "TABLE",
     * "      {{table2}}"=> "{{table1}}",
     * "      {{table1}}"=> "TABLE1",
     * "      {{table3}}"=> "{{table3}}",
     *     )
     * );
     * var_dump($result);
     *
     *
     * @param string $text
     * @param array|null $replace
     *
     * @return string
     * @throws \Exception
     */
    public static function replace($text, $replace)
    {
        if (!is_string($text)) {

            throw new \Exception('Invalid parameter "text". ' . __METHOD__);
        }

        $result = (string)$text;

        if ($replace === null) {

            return $result;
        }
        if (!is_array($replace)) {

            throw new \Exception(
                'Invalid parameter "replace".'
                . ' Must be array or null '
                . __METHOD__
            );
        }

        $keys = array_keys($replace);
        $length = array_combine($keys, array_map('strlen', $keys));
        arsort($length);

        $array[] = $text;
        $count = 1;
        reset($length);
        while ($key = key($length)) {
            if (strpos($text, $key) !== false) {
                for ($i = 0; $i < $count; $i += 2) {
                    if (($pos = strpos($array[$i], $key)) === false) {

                        continue;
                    }
                    array_splice(
                        $array,
                        $i,
                        1,
                        array(
                            substr($array[$i], 0, $pos),
                            $replace[$key],
                            substr($array[$i], $pos + strlen($key))
                        )
                    );
                    $count += 2;
                }
            }
            next($length);
        }
        $result = (string)implode('', $array);

        return $result;
    }


}
