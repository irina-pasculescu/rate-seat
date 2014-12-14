<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 8/8/14
 * Time: 10:13 AM
 */

namespace Application\Utils\ArrayProcessor;

/**
 * Class ArrayFilterRecursiveProcessor
 * @package Application\Utils\ArrayProcessor
 */
class ArrayFilterRecursiveProcessor
{


    /**
     * @var string
     */
    protected $rootPropertyQName = 'root';


    /**
     * @var string
     */
    protected $propertyQNameDelimiter = '.';

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
     * @param          $array
     * @param callable $callback
     *
     * @return array|mixed
     */
    public function run( $array, \Closure $callback )
    {
        $this->recursionLevel       = 0;
        $this->parentPropertyQName  = $this->rootPropertyQName;
        $this->currentPropertyQName = $this->rootPropertyQName;
        $this->currentKey           = '';
        $this->currentValue         = $array;

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
     *
     * @return array|mixed
     * @throws \Exception
     */
    private function processArray( $array, $parentQName, $currentKey, $isRoot )
    {
        $dataFinal = array();

        $this->parentPropertyQName = $parentQName;

        if ( $isRoot ) {
            $this->currentKey           = $currentKey;
            $this->currentPropertyQName = $currentKey;
        }
        else {
            $this->currentPropertyQName = implode(
                $this->propertyQNameDelimiter,
                array( $parentQName, $currentKey )
            );
        }

        $currentPropertyQName = $this->getCurrentPropertyQName();


        $this->currentValue = $array;
        $this->currentKey   = $currentKey;

        if ( is_array( $array ) ) {
            foreach ( $array as $key => $value ) {

                $m = $this->itemFunction(
                    $value,
                    $currentPropertyQName,
                    $key,
                    false
                );

                if ( !$m ) {

                    continue;
                }

                $dataFinal[ $key ] = $value;

                if ( is_array( $value ) ) {

                    $dataFinal[ $key ] = $this->processArray(
                        $value,
                        $currentPropertyQName,
                        $key,
                        false
                    );
                }

            }

        }


        return $dataFinal;
    }


    /**
     * @param $value
     * @param $parentQName
     * @param $currentKey
     * @param $isRoot
     *
     * @return bool
     * @throws \Exception
     */
    private function itemFunction( $value, $parentQName, $currentKey, $isRoot )
    {
        $this->currentValue        = $value;
        $this->currentKey          = $currentKey;
        $this->parentPropertyQName = $parentQName;
        if ( $isRoot ) {
            $this->currentKey           = $currentKey;
            $this->currentPropertyQName = $currentKey;
        }
        else {
            $this->currentPropertyQName = implode(
                $this->propertyQNameDelimiter,
                array( $parentQName, $currentKey )
            );
        }

        if ( !is_callable( $this->callback ) ) {

            throw new \Exception( 'Callback is not callable!' );
        }
        $isMatched = call_user_func_array(
                         $this->callback,
                         array( $this )
                     ) === true;

        return $isMatched;
    }


} 