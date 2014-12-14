<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 1/29/13
 * Time: 10:15 AM
 * To change this template use File | Settings | File Templates.
 */
namespace Application;

/**
 * Class Profiler
 *
 * @package Application
 */
class Profiler
{

    private $oboeEnabled = true;

    const COMMAND_START = 'start';
    const COMMAND_STOP  = 'stop';

    private $items             = array();
    private $startTime         = 0;
    private $startMicroTime    = 0;
    private $stopTime          = 0;
    private $stopMicroTime     = 0;
    private $durationTime      = 0;
    private $durationMicroTime = 0;


    /**
     * @return int
     */
    public function getStartMicroTime()
    {
        return (float)$this->startMicroTime;
    }

    /**
     * @return int
     */
    public function getStartTime()
    {
        return (int)$this->startTime;
    }

    /**
     * @return int
     */
    public function getStopMicroTime()
    {
        return (float)$this->stopMicroTime;
    }

    /**
     * @return int
     */
    public function getStopTime()
    {
        return (int)$this->stopTime;
    }


    /**
     * @return int
     */
    public function getDurationMicroTime()
    {
        return (float)$this->stopMicroTime;
    }

    /**
     * @return int
     */
    public function getDurationTime()
    {
        return (int)$this->durationTime;
    }


    /**
     * @return array
     */
    public function getItems()
    {
        return (array)$this->items;
    }

    /**
     * @return $this
     */
    public function start()
    {
        $this->startTime      = time();
        $this->startMicroTime = microtime( true );

        return $this;
    }

    /**
     * @return $this
     */
    public function stop()
    {
        $this->stopTime      = time();
        $this->stopMicroTime = microtime( true );

        if ( $this->startTime !== 0 ) {
            $this->durationTime = $this->stopTime - $this->startTime;
        }

        if ( $this->startMicroTime !== 0 ) {
            $this->durationMicroTime
                = $this->stopMicroTime - $this->startMicroTime;
        }

        return $this;
    }

    /**
     * @param string     $key
     * @param null|mixed $debugLog
     *
     * @return $this
     */
    public function startTrackingByKey( $key, $debugLog = null )
    {
        if ( $this->startTime === 0 ) {
            $this->startTime = time();
        }
        if ( $this->startMicroTime === 0 ) {
            $this->startMicroTime = microtime( true );
        }

        $time      = time();
        $microTime = microtime( true );

        $startDurationMicroTime = 0;
        if ( $this->startMicroTime !== 0 ) {
            $startDurationMicroTime = $microTime - $this->startMicroTime;
        }
        $startDurationTime = 0;
        if ( $this->startTime !== 0 ) {
            $startDurationTime = $time - $this->startTime;
        }


        $command = $this::COMMAND_START;

        $item                            = array(
            'key'                   => $key,
            'command'               => $command,
            'time'                  => $time,
            'microTime'             => $microTime,
            'initTime'              => $this->startTime,
            'initMicroTime'         => $this->startMicroTime,
            'initDurationTime'      => $startDurationTime,
            'initDurationMicroTime' => $startDurationMicroTime,
            'debugLog'              => $debugLog,
        );
        $this->items[ $key ][ $command ] = $item;


        return $this;
    }

    /**
     * @param string     $key
     * @param null|mixed $debugLog
     *
     * @return $this
     */
    public function stopTrackingByKey( $key, $debugLog = null )
    {
        $command = $this::COMMAND_STOP;

        $time      = time();
        $microTime = microtime( true );

        $startDurationMicroTime = 0;
        if ( $this->startMicroTime !== 0 ) {
            $startDurationMicroTime = $microTime - $this->startMicroTime;
        }
        $startDurationTime = 0;
        if ( $this->startTime !== 0 ) {
            $startDurationTime = $time - $this->startTime;
        }

        $item                            = array(
            'key'                   => $key,
            'command'               => $command,
            'time'                  => $time,
            'microTime'             => $microTime,
            'initTime'              => $this->startTime,
            'initMicroTime'         => $this->startMicroTime,
            'initDurationTime'      => $startDurationTime,
            'initDurationMicroTime' => $startDurationMicroTime,
            'debugLog'              => $debugLog,
        );
        $this->items[ $key ][ $command ] = $item;

        $this->calcDurationByKey( $key );


        return $this;
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function getItemsDictionaryByKey( $key )
    {
        $items = $this->items;
        if ( !isset( $items[ $key ] ) ) {
            $items[ $key ] = array();
        }
        if ( !isset( $items[ $key ][ $this::COMMAND_START ] ) ) {
            $items[ $key ][ $this::COMMAND_START ] = null;
        }
        if ( !isset( $items[ $key ][ $this::COMMAND_STOP ] ) ) {
            $items[ $key ][ $this::COMMAND_STOP ] = null;
        }
        $this->items = $items;

        return $items[ $key ];
    }

    /**
     * @param $key
     *
     * @return $this
     */
    public function calcDurationByKey( $key )
    {
        $dictionary = $this->getItemsDictionaryByKey( $key );
        $startItem  = $dictionary[ $this::COMMAND_START ];
        $stopItem   = $dictionary[ $this::COMMAND_STOP ];

        if ( !is_array( $stopItem ) ) {
            $stopItem = array(
                'key'                   => $key,
                'command'               => $this::COMMAND_STOP,
                'time'                  => 0,
                'microTime'             => 0,
                'initTime'              => $this->startTime,
                'initMicroTime'         => $this->startMicroTime,
                'initDurationTime'      => 0,
                'initDurationMicroTime' => 0,
            );
        }
        if ( !is_array( $startItem ) ) {
            $startItem = array(
                'key'                   => $key,
                'command'               => $this::COMMAND_START,
                'time'                  => 0,
                'microTime'             => 0,
                'initTime'              => $this->startTime,
                'initMicroTime'         => $this->startMicroTime,
                'initDurationTime'      => 0,
                'initDurationMicroTime' => 0,
            );
        }

        $stopItem[ 'durationTime' ]      = 0;
        $stopItem[ 'durationMicroTime' ] = 0;

        if ( ( $stopItem[ 'time' ] > 0 ) && ( $startItem[ 'time' ] > 0 ) ) {
            $stopItem[ 'durationTime' ] = $stopItem[ 'time' ] - $startItem[ 'time' ];
        }

        if ( ( $stopItem[ 'microTime' ] > 0 ) && ( $startItem[ 'microTime' ] > 0 ) ) {
            $stopItem[ 'durationMicroTime' ] = $stopItem[ 'microTime' ] - $startItem[ 'microTime' ];
        }

        if ( $stopItem[ 'durationMicroTime' ] > 0 ) {
            $stopItem[ 'requestsPerSeconds' ] = 1 / $stopItem[ 'durationMicroTime' ];
        }

        $dictionary[ $this::COMMAND_START ] = $startItem;
        $dictionary[ $this::COMMAND_STOP ]  = $stopItem;


        $this->items[ $key ] = $dictionary;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsOboeEnabled()
    {
        return ( $this->oboeEnabled === true );
    }

    /**
     * @param string $key
     *
     * @return $this
     */
    public function oboeStart( $key )
    {
        if ( !$this->getIsOboeEnabled() ) {

            return $this;
        }

        $command = 'profile_entry';
        if ( function_exists( 'oboe_log' ) ) {
            try {
                oboe_log(
                    $command,
                    array(
                        'ProfileName' => (string)$key,
                    )
                );
            }
            catch (\Exception $e) {
                //nop
            }
        }

        return $this;
    }

    /**
     * @param string $key
     *
     * @return $this
     */
    public function oboeStop( $key )
    {
        if ( !$this->getIsOboeEnabled() ) {

            return $this;
        }

        $command = 'profile_exit';
        if ( function_exists( 'oboe_log' ) ) {
            try {
                oboe_log(
                    $command,
                    array(
                        'ProfileName' => (string)$key,
                    )
                );
            }
            catch (\Exception $e) {
                //nop
            }
        }

        return $this;
    }


    /**
     *
     * @param string $controller
     * @param string $action
     *
     * @return $this
     */
    public function oboeTagControllerAction( $controller, $action )
    {
        if ( !$this->getIsOboeEnabled() ) {

            return $this;
        }

        if ( !function_exists( 'oboe_log' ) ) {

            return $this;
        }

        try {
            oboe_log(
                'info',
                array(
                    'Controller' => (string)$controller,
                    'Action'     => (string)$action,
                )
            );
        }
        catch (\Exception $e) {
            //nop
        }

        return $this;

    }
}
