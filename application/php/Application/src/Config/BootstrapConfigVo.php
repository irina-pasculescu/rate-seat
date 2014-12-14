<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/16/14
 * Time: 9:56 AM
 */

namespace Application\Config;

use Application\BaseVo;

/**
 * Class BootstrapConfigVo
 *
 * @package Application\Config
 */
class BootstrapConfigVo extends BaseVo
{


    /**
     * @return bool|null
     */
    public function getDisplayExceptionsEnabled()
    {
        $key   = 'displayExceptionsEnabled';
        $value = $this->getDataKey( $key );

        if ( is_bool( $value ) ) {

            return $value === true;
        }

        return null;
    }

    /**
     * @return bool|null
     */
    public function getErrorExceptionsEnabled()
    {
        $key   = 'errorExceptionsEnabled';
        $value = $this->getDataKey( $key );

        if ( is_bool( $value ) ) {

            return $value === true;
        }

        return null;
    }


    /**
     * @return bool|null
     */
    public function getDisplayErrorsEnabled()
    {
        $key   = 'displayErrorsEnabled';
        $value = $this->getDataKey( $key );

        if ( is_bool( $value ) ) {

            return $value === true;
        }

        return null;
    }

    /**
     * @return array
     */
    public function getPhpIni()
    {
        $key   = 'phpIni';
        $value = $this->getDataKey( $key );
        if ( is_array( $value ) ) {

            return (array)$value;
        }

        return array();
    }
} 