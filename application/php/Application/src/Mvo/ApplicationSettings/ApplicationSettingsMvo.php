<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/11/14
 * Time: 3:12 PM
 */

namespace Application\Mvo\ApplicationSettings;


use Application\Definition\StringStrictNotEmptyType;
use Application\Definition\UintType;
use Application\Mvo\Base\BaseMvo;
use Application\Utils\ClassUtil;

class ApplicationSettingsMvo extends BaseMvo
{


    // required
    const DATA_KEY_MVO_TYPE  = 'mvoType';
    const MVO_TYPE_PREFERRED = 'rate-seat:application:settings'; // player, user:info, ...

    // custom
    const KEY_RATE_SEAT_API_CLIENT = 'RateSeatApiClient';


    // ========= implement abstracts ==========

    /**
     * @return UintType
     */
    protected function getMvoTtlPreferred()
    {
        $value = 0; // never expire

        return new UintType( $value );
    }


    /**
     * @throws \Exception
     * @return $this
     */
    protected function validateBeforeSave()
    {

        $method = ClassUtil::getQualifiedMethodName( $this, __METHOD__, true );
        $this->requireHasData( $method );

        return $this;
    }


    // ========== custom: memId, load, save ================

    /**
     * @return StringStrictNotEmptyType
     */
    public function createMemId()
    {

        $mvoMemId = implode(
            ':',
            array(
                $this::MVO_TYPE_PREFERRED,
            )
        );

        return new StringStrictNotEmptyType(
            $mvoMemId,
            'Invalid mvo.mvoMemId!'
            . ' ' . ClassUtil::getQualifiedMethodName( $this, __METHOD__, true )
        );
    }


    /**
     * @return $this
     */
    public function load()
    {
        $mvoMemId = $this->createMemId();

        $this->setMvoMemId( $mvoMemId );

        $this->loadMvo();

        return $this;
    }

    /**
     * @return $this
     */
    public function save()
    {
        $mvoMemId = $this->createMemId();

        $this->setMvoMemId( $mvoMemId );
        $this->requireHasData( null );


        $this->validateBeforeSave();

        $this->saveMvo();

        return $this;
    }


    // ================ custom: accessors ====================

    /**
     * @return RateSeatApiClientSettingsVo
     */
    public function getRateSeatApiClientSettingsVo()
    {
        $key   = $this::KEY_RATE_SEAT_API_CLIENT;
        $value = $this->getDataKey( $key );

        $vo = new RateSeatApiClientSettingsVo();
        if ( is_array( $value ) ) {
            $vo->setData( $value );
        }

        return $vo;
    }


} 