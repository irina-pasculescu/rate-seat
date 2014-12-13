<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 6/26/13
 * Time: 2:49 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Utils;

/**
 * Class ClassUtil
 * @package Application\Utils
 */
class ClassUtil
{

    /**
     * @param object|string $class
     * @param bool $autoLoad
     * @param bool $delegateExceptions
     *
     * @return bool
     */
    public static function classExists($class, $autoLoad, $delegateExceptions)
    {
        $result = false;
        $delegateExceptions = ($delegateExceptions === true);
        $autoLoad = ($autoLoad === true);
        if ($delegateExceptions) {

            return (class_exists($class, $autoLoad) === true);
        }

        try {

            return (class_exists($class, $autoLoad) === true);
        } catch (\Exception $e) {
            // nop
        }

        return $result;
    }

    /**
     * @param object|string $instance
     *
     * @return string
     */
    public static function getClassName($instance)
    {
        $result = '';

        if ($instance === null) {

            return 'null';
        }

        $className = null;
        if (is_string($instance)) {
            $className = $instance;
        }

        if (is_object($instance)) {

            try {
                $className = get_class($instance);
            } catch (\Exception $e) {
                //NOP
            }
        }

        if (!is_string($className)) {

            return $result;
        }

        if (empty($className)) {

            return $result;
        }

        return $className;
    }

    /**
     * @param object|string $instance
     *
     * @return string
     */
    public static function getClassNameAsJavaStyle($instance)
    {
        $className = self::getClassName($instance);

        $classNameNice = str_replace(
            array('_', '\\'),
            '.',
            $className
        );

        return $classNameNice;
    }

    /**
     * @param string|object $class
     * @param string $method
     * @param bool $useJavaStyle
     *
     * @return string
     */
    public static function getQualifiedMethodName(
        $class,
        $method,
        $useJavaStyle
    ) {
        $useJavaStyle = ($useJavaStyle === true);

        if ($useJavaStyle) {
            $className = (string)self::getClassNameAsJavaStyle($class);
        } else {
            $className = (string)self::getClassName($class);
        }

        $method = (string)$method;

        $methodName = $method;
        $delimiters = array(
            '::', // php
            '.' // java style
        );
        foreach ($delimiters as $delimiter) {
            if (strpos($methodName, $delimiter) !== false) {
                $methodParts = (array)explode($delimiter, $method);
                $lastMethodPart = array_pop($methodParts);
                $methodName = (string)$lastMethodPart;

                break;
            }
        }

        $resultDelimiter = '::';
        if ($useJavaStyle) {
            $resultDelimiter = '.';
        }

        $resultParts = array();

        $parts = array(
            $className,
            $methodName
        );

        foreach ($parts as $part) {
            if ((is_string($part)) && (!empty($part))) {
                $resultParts[] = $part;
            }
        }

        $result = (string)implode(
            $resultDelimiter,
            $resultParts
        );

        return $result;

    }

    /**
     * @param string $text
     *
     * @return string
     */
    public static function toJavaStyle($text)
    {
        if (!is_string($text)) {

            return '';
        }

        return (string)str_replace(
            array('\\', '::'),
            array('.', '.'),
            $text
        );
    }

}