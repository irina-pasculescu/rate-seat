<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 8/7/14
 * Time: 5:32 PM
 */

namespace Application\Utils\ArrayProcessor;

use Application\Utils\ClassUtil;

/**
 * @EXPERIMENTAL
 * Class ArrayMapRecursiveProcessor
 * @package Application\Utils\ArrayProcessor
 */
class ArrayMapRecursiveProcessor
{

    /**
     * @var string
     */
    protected $rootPropertyQName = 'root';

    /**
     * @param string $value
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setRootPropertyQName($value)
    {
        if (!is_string($value)) {

            throw new \InvalidArgumentException(
                'Parameter "value" must be a string! ('
                . ClassUtil::getQualifiedMethodName($this, __METHOD__, true)
                . ')'
            );
        }

        $this->rootPropertyQName = $value;

        return $this;
    }


    /**
     * @var string
     */
    protected $propertyQNameDelimiter = '.';


    /**
     * @param string $value
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setPropertyQNameDelimiter($value)
    {
        if (!is_string($value)) {

            throw new \InvalidArgumentException(
                'Parameter "value" must be a string! ('
                . ClassUtil::getQualifiedMethodName($this, __METHOD__, true)
                . ')'
            );
        }

        $this->propertyQNameDelimiter = $value;

        return $this;
    }


    /**
     * @return null
     */
    public function getCurrentKey()
    {
        return $this->currentKey;
    }

    /**
     * @return null
     */
    public function getCurrentValue()
    {
        return $this->currentValue;
    }

    /**
     * @return string
     */
    public function getCurrentPropertyQName()
    {
        return $this->currentPropertyQName;
    }

    /**
     * @return string
     */
    public function getParentPropertyQName()
    {
        return $this->parentPropertyQName;
    }

    /**
     * @return string
     */
    public function getPropertyQNameDelimiter()
    {
        return $this->propertyQNameDelimiter;
    }

    /**
     * @return int
     */
    public function getRecursionLevel()
    {
        return $this->recursionLevel;
    }

    /**
     * @return string
     */
    public function getRootPropertyQName()
    {
        return $this->rootPropertyQName;
    }

    /**
     * @var int
     */
    protected $recursionLevel = 0;

    /**
     * @var null
     */
    protected $currentValue = null;

    /**
     * @var string
     */
    protected $currentKey = '';
    /**
     * @var string
     */
    protected $parentKey = '';

    /**
     * @var string
     */
    protected $parentPropertyQName = '';

    /**
     * @var string
     */
    protected $currentPropertyQName = '';

    /**
     * @var null
     */
    protected $callback = null;

    /**
     * @param $array
     * @param callable $callback
     * @return array|mixed
     */
    public function run($array, \Closure $callback)
    {
        $this->recursionLevel = 0;
        $this->parentPropertyQName = $this->rootPropertyQName;
        $this->currentPropertyQName = $this->rootPropertyQName;
        $this->currentKey = '';
        $this->currentValue = $array;

        $this->callback = $callback;


        return $this->processArray(
            $array,
            '',
            $this->getRootPropertyQName(),
            true
        );
    }


    /**
     * @param $array
     * @param $parentQName
     * @param $currentKey
     * @param $isRoot
     * @return array|mixed
     * @throws \Exception
     */
    private function processArray($array, $parentQName, $currentKey, $isRoot)
    {
        $dataFinal = array();

        $this->parentPropertyQName = $parentQName;

        if ($isRoot) {
            $this->currentKey = $currentKey;
            $this->currentPropertyQName = $currentKey;
        } else {
            $this->currentPropertyQName = implode(
                $this->propertyQNameDelimiter,
                array($parentQName, $currentKey)
            );
        }

        $currentPropertyQName = $this->getCurrentPropertyQName();


        $this->currentValue = $array;
        $this->currentKey = $currentKey;

        if (!is_callable($this->callback)) {

            throw new \Exception('Callback is not callable!');
        }
        $array = call_user_func_array($this->callback, array($this));
        if (!is_array($array)) {

            return $array;
        }


        foreach ($array as $key => $value) {

            $this->currentKey = $key;
            $this->currentValue = $value;


            $dataFinal[$key] = $this->processArray(
                $value,
                $currentPropertyQName,
                $key,
                false
            );

        }

        return $dataFinal;
    }


}