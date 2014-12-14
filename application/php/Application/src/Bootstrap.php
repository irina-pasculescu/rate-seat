<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 4/22/13
 * Time: 10:48 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Application;

/**
 * Class Bootstrap
 *
 * @package Application
 */
class Bootstrap extends BaseBootstrap
{

    const PROJECT_NAME = 'rate-seat';

    /**
     * @var self
     */
    private static $instance;

    /**
     * @return self
     */
    public static function getInstance()
    {
        if ( !self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->getContext()->getModel();
    }


    /**
     * @return $this
     */
    protected function initLocale()
    {
        parent::initLocale();

        date_default_timezone_set( 'UTC' );

        return $this;
    }


}