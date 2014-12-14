<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 4/30/13
 * Time: 1:49 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Application;

use Application\Utils\ArrayAssocUtil;

/**
 * Class Exception
 *
 * @package Application
 */
class Exception extends \Exception
{
    const ERROR_DEPRECATED_METHOD_CALL = 'ERROR_DEPRECATED_METHOD_CALL';

    /**
     * exposed to client
     *
     * @var array;
     */
    protected $data = array();


    /**
     * usually not to be exposed to the client (just in debug mode)
     *
     * @var array
     */
    protected $debug = array();

    /**
     * @param string     $message
     * @param null|array $data
     * @param null|array $debug
     * @param int        $code
     * @param \Exception $previous
     */
    public function __construct(
        $message = "",
        $data = null,
        $debug = null,
        $code = 0,
        \Exception $previous = null
    )
    {
        parent::__construct(
            $message,
            $code,
            $previous
        );

        $this->setData( $data );
        $this->setDebug( $debug );
    }


    /**
     * @param $message
     *
     * @return $this
     */
    public function setMessage( $message )
    {
        $this->message = (string)$message;

        return $this;
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function setData( $data )
    {
        if ( !is_array( $data ) ) {
            $data = array();
        }
        $this->data = $data;

        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        if ( !is_array( $this->data ) ) {
            $this->data = array();
        }

        return $this->data;
    }

    /**
     * @return bool
     */
    public function hasData()
    {
        $data = $this->getData();

        return (
            is_array( $data )
            && ( count( array_keys( $data ) ) > 0 )
        );
    }

    /**
     * @param array $mixin
     *
     * @return $this
     */
    public function mixinData( $mixin )
    {
        $data       = $this->getData();
        $data       = ArrayAssocUtil::mixinOverride( $data, $mixin, null );
        $this->data = $data;

        return $this;
    }


    /**
     * @param array $debug
     *
     * @return $this
     */
    public function setDebug( $debug )
    {
        if ( !is_array( $debug ) ) {
            $debug = array();
        }
        $this->debug = $debug;

        return $this;
    }

    /**
     * @return array
     */
    public function getDebug()
    {
        if ( !is_array( $this->debug ) ) {
            $this->debug = array();
        }

        return $this->debug;
    }

    /**
     * @return bool
     */
    public function hasDebug()
    {
        $debug = $this->getDebug();

        return (
            is_array( $debug )
            && ( count( array_keys( $debug ) ) > 0 )
        );
    }

    /**
     * @param array $mixin
     *
     * @return $this
     */
    public function mixinDebug( $mixin )
    {
        $debug       = $this->getDebug();
        $debug       = ArrayAssocUtil::mixinOverride( $debug, $mixin, null );
        $this->debug = $debug;

        return $this;
    }

    /**
     * @param string $key
     *
     * @return mixed|null
     */
    public function getDebugKey( $key )
    {
        $result = null;
        $debug  = $this->getDebug();

        if ( array_keys( $debug, $key, true ) ) {
            return $debug[ $key ];
        }

        return $result;
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function setDebugKey( $key, $value )
    {
        $debug         = $this->getDebug();
        $debug[ $key ] = $value;
        $this->setDebug( $debug );

        return $this;
    }

}