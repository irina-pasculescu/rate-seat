<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/24/14
 * Time: 3:44 PM
 */

namespace Application\Mvo\Base;

use Application\Context;
use Application\Definition\ArrayAssocNotEmptyType;
use Application\Definition\StringStrictNotEmptyType;
use Application\Definition\UintType;
use Application\Definition\UintTypeNotEmpty;
use Application\Utils\ArrayAssocUtil;
use Application\Utils\ClassUtil;
use Application\Utils\StringUtil;

/**
 * Class BaseMvo
 *
 * @package Application\Mvo\Base
 */
abstract class BaseMvo
{

    // required

    const DATA_KEY_MVO_TYPE  = ''; // mvoType, or type (old-backend-mvo') ...
    const MVO_TYPE_PREFERRED = ''; // player, user:info, ...

    // custom
    const DATA_KEY_MVO_TTL      = 'mvoTtl';
    const DATA_KEY_MVO_CREATED  = 'created';
    const DATA_KEY_MVO_MODIFIED = 'modified';

    /**
     * @return StringStrictNotEmptyType
     */
    public function getMvoTypePreferred()
    {
        return new StringStrictNotEmptyType(
            $this::MVO_TYPE_PREFERRED,
            'Invalid'
            . ' ' . ClassUtil::getQualifiedMethodName(
                $this,
                'MVO_TYPE_PREFERRED',
                true
            ) . ' !'
            . ' ('
            . ClassUtil::getQualifiedMethodName( $this, __METHOD__, true )
            . ')'
        );
    }


    /**
     * @return UintType
     */
    abstract protected function getMvoTtlPreferred();


    /**
     * @throws \Exception
     * @return $this
     */
    abstract protected function validateBeforeSave();


    /**
     *
     */
    public function __construct()
    {
        // validate
        $this->validateMvoPropertiesPreferred();
        // calc checksum for persistence
        $this->updateLastPersistenceDataChecksum();
    }

    /**
     * @return $this
     * @throws BaseMvoException
     */
    protected function validateMvoPropertiesPreferred()
    {
        try {
            // data keys
            $key = $this::DATA_KEY_MVO_TYPE;
            new StringStrictNotEmptyType(
                $key,
                'Invalid property:'
                . ' ' . ClassUtil::getQualifiedMethodName(
                    $this,
                    'DATA_KEY_MVO_TYPE',
                    true
                ) . ' !'
            );
            $key = $this::DATA_KEY_MVO_TTL;
            new StringStrictNotEmptyType(
                $key,
                'Invalid property:'
                . ' ' . ClassUtil::getQualifiedMethodName(
                    $this,
                    'DATA_KEY_MVO_TTL',
                    true
                ) . ' !'
            );
            $key = $this::DATA_KEY_MVO_CREATED;
            new StringStrictNotEmptyType(
                $key,
                'Invalid property:'
                . ' ' . ClassUtil::getQualifiedMethodName(
                    $this,
                    'DATA_KEY_MVO_CREATED',
                    true
                ) . ' !'
            );
            $key = $this::DATA_KEY_MVO_MODIFIED;
            new StringStrictNotEmptyType(
                $key,
                'Invalid property:'
                . ' ' . ClassUtil::getQualifiedMethodName(
                    $this,
                    'DATA_KEY_MVO_MODIFIED',
                    true
                ) . ' !'
            );

            // preferred values
            new StringStrictNotEmptyType(
                $this->getMvoTypePreferred(),
                'Invalid mvo.getMvoTypePreferred !'
            );
            // a value for mvoTypePreferred must be given
            new UintType(
                $this->getMvoTtlPreferred(),
                'Invalid mvo.getMvoTypePreferred !'
            );


            return $this;

        }
        catch (\Exception $e) {

            throw new BaseMvoException(
                'Mvo contains errors! '
                . ' (' . ClassUtil::getQualifiedMethodName(
                    $this,
                    __METHOD__,
                    true
                ) . '
                    )'
                . ' details: ' . $e->getMessage()

            );
        }
    }

    /**
     * NOTE: it is not recommended re-using an mvo instance
     * But if you really need to, use the resetMvo method
     * to re-initialise the mvo
     *
     * @return $this
     */
    public function resetMvo()
    {
        $this->mvoMemId                       = null;
        $this->data                           = null;
        $this->hasMvoDataLoaded               = false;
        $this->lastMvoPersistenceDataChecksum = null;
        $this->mvoLoadedAtMicroTime           = null;
        $this->mvoSavedAtMicroTime            = null;

        $this->updateLastPersistenceDataChecksum();

        return $this;
    }


    /**
     * @var
     */
    protected $data = array();

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
     * @param array|\stdClass $value
     *
     * @return $this
     * @throws \Exception
     */
    public function setData( $value )
    {
        if ( $value instanceof \stdClass ) {
            $value = (array)get_object_vars( $value );
        }

        if ( !is_array( $value ) ) {

            throw new \Exception(
                'Invalid value! '
                . ClassUtil::getQualifiedMethodName( $this, __METHOD__, true )
            );
        }

        $this->data = $value;

        return $this;
    }

    /**
     * @return $this
     */
    public function unsetData()
    {
        $this->data = null;

        return $this;
    }

    /**
     * @param       $key
     * @param mixed $value
     *
     * @return $this
     */
    public function setDataKey( $key, $value )
    {
        $data         = $this->getData();
        $data[ $key ] = $value;
        $this->setData( $data );

        return $this;
    }

    /**
     * @param $key
     *
     * @return mixed|null
     */
    public function getDataKey( $key )
    {
        $result = null;
        $data   = $this->getData();
        if ( array_key_exists( $key, $data ) ) {
            $result = $data[ $key ];
        }

        return $result;
    }

    /**
     * @var string
     */
    protected $mvoMemId = '';

    /**
     * @param StringStrictNotEmptyType $value
     *
     * @return $this
     */
    public function setMvoMemId( StringStrictNotEmptyType $value )
    {
        $this->mvoMemId = $value->getValue();

        return $this;
    }

    /**
     * @return string
     */
    public function getMvoMemId()
    {
        return (string)StringStrictNotEmptyType::cast( $this->mvoMemId, '' );
    }


    /**
     * @return $this
     */
    protected function loadMvo()
    {
        $mvoMemId = new StringStrictNotEmptyType(
            $this->getMvoMemId(),
            'Invalid mvo.mvoMemId ! '
            . ClassUtil::getQualifiedMethodName( $this, __METHOD__, true )
        );

        $this->setMvoLoadedAtMicroTime( microtime( true ) );
        $value = $this->getCbKey( $mvoMemId );


        // import the data we just loaded
        $this->importMvoLoadedData( $value );

        // remember the checksum of the data that has been loaded and imported,
        // that is required for isDirty()
        $this->updateLastPersistenceDataChecksum();


        // run custom hook
        $this->onMvoLoaded();

        return $this;
    }

    /**
     * @param array|\stdClass|null|mixed $data
     *
     * @return $this
     */
    protected function importMvoLoadedData( $data )
    {
        if ( $data instanceof \stdClass ) {
            $data = (array)get_object_vars( $data );
        }

        $this->data = $data;

        $this->hasMvoDataLoaded = $this->hasData();

        return $this;
    }

    /**
     * @return $this
     */
    protected function saveMvo()
    {

        $this->validateBeforeSaveMvo();
        $this->validateMvoPropertiesPreferred();

        $currentMicroTimestamp = microtime( true );
        $currentTimestamp      = (int)floor( $currentMicroTimestamp );


        $data = (array)$this->getData();

        $keyMvoType     = $this::DATA_KEY_MVO_TYPE;
        $keyMvoTtl      = $this::DATA_KEY_MVO_TTL;
        $keyMvoCreated  = $this::DATA_KEY_MVO_CREATED;
        $keyMvoModified = $this::DATA_KEY_MVO_MODIFIED;

        // add data.mvoType
        $mvoTypePreferred    = $this->getMvoTypePreferred();
        $data[ $keyMvoType ] = $mvoTypePreferred->getValue();
        // add data.modified timestamp
        $mvoModified             = new UintTypeNotEmpty( $currentTimestamp );
        $data[ $keyMvoModified ] = $mvoModified->getValue();
        // add data.created timestamp (if not exists)
        $created = (int)UintTypeNotEmpty::cast(
            ArrayAssocUtil::getProperty( $data, $keyMvoCreated ),
            0
        );
        if ( $created < 1 ) {
            $created = $currentTimestamp;
        }
        $mvoCreated             = new UintTypeNotEmpty( $created );
        $data[ $keyMvoCreated ] = $mvoCreated->getValue();
        // add data.mvoTtl
        $mvoTtlPreferred    = new UintType( $this->getMvoTtlPreferred() );
        $data[ $keyMvoTtl ] = $mvoTtlPreferred->getValue();

        // calculate mvoExpireAt for saving to cb
        $mvoExpireAt = new UintType( 0 );
        if ( $mvoTtlPreferred->getValue() !== 0 ) {
            $mvoExpireAt = new UintType(
                $currentTimestamp + $mvoTtlPreferred->getValue()
            );
        }


        // save to cb
        $this->saveCbKey(
            new StringStrictNotEmptyType( $this->getMvoMemId() ),
            new ArrayAssocNotEmptyType( $data ),
            $mvoExpireAt
        );

        // remember the time when mvo was saved
        $this->setMvoSavedAtMicroTime( microtime( true ) );

        // inject the meta data into mvo.data
        $this->setDataKey( $keyMvoType, $mvoTypePreferred->getValue() );
        $this->setDataKey( $keyMvoTtl, $mvoTtlPreferred->getValue() );
        $this->setDataKey( $keyMvoCreated, $mvoCreated->getValue() );
        $this->setDataKey( $keyMvoModified, $mvoModified->getValue() );


        // remember the checksum of the data that has been saved,
        // that is required for isDirty()
        $this->updateLastPersistenceDataChecksum();

        // run custom hook
        $this->onMvoSaved();

        return $this;
    }


    /**
     * @var float
     */
    protected $mvoSavedAtMicroTime = 0.0;

    /**
     * @param float $value
     *
     * @return $this
     */
    protected function setMvoSavedAtMicroTime( $value )
    {
        $this->mvoSavedAtMicroTime = $value;

        return $this;
    }

    /**
     * @return float
     */
    protected function getMvoSavedAtMicroTime()
    {
        $value = (float)$this->mvoSavedAtMicroTime;
        if ( $value < 0 ) {
            $value = 0.0;
        }

        return (float)$value;
    }

    /**
     * @var float
     */
    protected $mvoLoadedAtMicroTime = 0.0;

    /**
     * @param float $value
     *
     * @return $this
     */
    protected function setMvoLoadedAtMicroTime( $value )
    {
        $this->mvoLoadedAtMicroTime = $value;

        return $this;
    }

    /**
     * @return float
     */
    public function getMvoLoadedAtMicroTime()
    {
        $value = (float)$this->mvoLoadedAtMicroTime;
        if ( $value < 0 ) {
            $value = 0;
        }

        return (float)$value;

    }

    /**
     * @return $this
     */
    protected function onMvoSaved()
    {
        return $this;
    }

    /**
     * @return $this
     */
    protected function onMvoLoaded()
    {
        return $this;
    }


    /**
     * @return $this
     */
    protected function validateBeforeSaveMvo()
    {
        $methodName = ClassUtil::getQualifiedMethodName(
            $this,
            __METHOD__,
            true
        );
        // validate: memId
        new StringStrictNotEmptyType(
            $this->getMvoMemId(),
            'Invalid mvo.mvoMemId !'
            . ' ' . $methodName
        );

        // validate: data
        $this->requireHasData( $methodName );


        return $this;
    }

    /**
     * @param string|null $errorDetails
     *
     * @return $this
     * @throws \Exception
     */
    public function requireHasData( $errorDetails )
    {
        $className = ClassUtil::getClassNameAsJavaStyle( $this );

        $errorMessage = StringUtil::joinStrictIfNotEmpty(
            ' ',
            array(
                'Invalid mvo.data !',
                'mvoClass = ' . $className,
                $errorDetails
            )
        );

        if ( !$this->hasData() ) {

            throw new \Exception( $errorMessage );
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function hasData()
    {
        return ArrayAssocNotEmptyType::isValid( $this->getData() );
    }


    /**
     * @param string|null $errorDetails
     *
     * @return $this
     * @throws \Exception
     */
    public function requireIsLoaded( $errorDetails )
    {
        if ( $this->isMvoLoaded() ) {

            return $this;
        }

        $errorMessage = StringUtil::joinStrictIfNotEmpty(
            ' ',
            array(
                'Mvo not loaded!',
                ' mvoClass = ' . ClassUtil::getClassNameAsJavaStyle( $this ),
                ' mvoMemId = ' . $this->getMvoMemId() . ' ! '
                . ' details: ' . $errorDetails
            )
        );

        throw new \Exception( $errorMessage );
    }


    /**
     * @return bool
     */
    public function isMvoLoaded()
    {
        $mvoLoadedAt = $this->getMvoLoadedAtMicroTime();

        if ( $mvoLoadedAt < 1 ) {

            return false;
        }

        if ( !$this->hasMvoDataLoaded() ) {

            return false;
        }

        if ( !$this->hasData() ) {

            return false;
        }
        $dataCreated = $this->getMvoCreated();

        return $dataCreated > 0;
    }


    /**
     * @var string
     */
    protected $lastMvoPersistenceDataChecksum = '';

    /**
     * @return bool
     */
    public function isMvoDirty()
    {
        return $this->lastMvoPersistenceDataChecksum
               !== $this->calculateMvoDataPersistenceChecksum( $this->getData() );
    }

    /**
     * @param array|null $data
     *
     * @return string
     */
    protected function calculateMvoDataPersistenceChecksum( $data )
    {
        $json = json_encode( $data );

        return sha1( $json ) . md5( $json );
    }

    /**
     * @return $this
     */
    protected function updateLastPersistenceDataChecksum()
    {
        $this->lastMvoPersistenceDataChecksum
            = $this->calculateMvoDataPersistenceChecksum( $this->getData() );

        return $this;
    }


    /**
     * @var bool
     */
    protected $hasMvoDataLoaded = false;

    /**
     * @return bool
     */
    public function hasMvoDataLoaded()
    {
        return $this->hasMvoDataLoaded === true;
    }


    // ========= data accessor =============

    /**
     * @return int
     */
    public function getMvoTtl()
    {
        return (int)UintTypeNotEmpty::cast(
            $this->getDataKey( $this::DATA_KEY_MVO_TTL ),
            0
        );
    }

    /**
     * @return int
     */
    public function getMvoCreated()
    {
        return (int)UintTypeNotEmpty::cast(
            $this->getDataKey( $this::DATA_KEY_MVO_CREATED ),
            0
        );
    }

    /**
     * @return int
     */
    public function getMvoModified()
    {
        return (int)UintTypeNotEmpty::cast(
            $this->getDataKey( $this::DATA_KEY_MVO_MODIFIED ),
            0
        );
    }

    /**
     * @return string
     */
    public function getMvoType()
    {
        return (string)StringStrictNotEmptyType::cast(
            $this->getDataKey( $this::DATA_KEY_MVO_TYPE ),
            ''
        );
    }


    // ============= context ==========

    /**
     * @return Context
     */
    protected function getApplicationContext()
    {
        return Context::getInstance();
    }

    // ============ couchbase ===========


    /**
     * @return \Application\Lib\Couchbase\CouchbaseClient
     */
    protected function getCouchbaseClient()
    {
        return $this->getApplicationContext()->getCouchbaseClient();
    }


    /**
     * @param StringStrictNotEmptyType $key
     *
     * @return mixed|null
     */
    protected function getCbKey( StringStrictNotEmptyType $key )
    {
        $value = $this->getCouchbaseClient()
                      ->getSdkJson()
                      ->get( $key );

        return $value;
    }

    /**
     * @param StringStrictNotEmptyType $key
     * @param ArrayAssocNotEmptyType   $value
     * @param UintType                 $expiry
     *
     * @return string
     */
    protected function saveCbKey(
        StringStrictNotEmptyType $key,
        ArrayAssocNotEmptyType $value,
        UintType $expiry
    )
    {

        $casValue = $this->getCouchbaseClient()
                         ->getSdkJson()
                         ->set( $key, $value, $expiry );


        return $casValue;
    }


    // ========================================

} 