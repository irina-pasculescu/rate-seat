<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/24/14
 * Time: 3:32 PM
 */

namespace Application\Lib\Couchbase;

use Application\Definition\ArrayAssocNotEmptyType;
use Application\Definition\StringStrictNotEmptyType;
use Application\Definition\UintType;
use Application\Utils\ClassUtil;
use Application\Utils\ExceptionUtil;

/**
 * Class CouchbaseSdkJson
 *
 * @package Application\Lib\Couchbase
 */
class CouchbaseSdkJson
{

    /**
     * @var CouchbaseSdkNative
     */
    protected $sdkNative;

    /**
     * @return CouchbaseSdkNative
     */
    public function getSdkNative()
    {
        return $this->sdkNative;
    }

    /**
     * @param CouchbaseSdkNative $sdkNative
     */
    public function __construct( CouchbaseSdkNative $sdkNative )
    {
        $this->sdkNative = $sdkNative;
    }


    /**
     * @param StringStrictNotEmptyType $id
     * @param null                     $callback
     * @param string                   $cas
     *
     * @return mixed|null
     * @throws CouchbaseSdkJsonException
     */
    public function get(
        StringStrictNotEmptyType $id,
        $callback = null,
        &$cas = ""
    )
    {
        $sdkNative = $this->getSdkNative();

        try {

            $text = $sdkNative->get( $id->getValue(), $callback, $cas );
            $data = $this->decode( $text );

            return $data;

        }
        catch (\Exception $e) {

            $cbException = new CouchbaseSdkJsonException(
                'CB Read Operation Failed! details=' . $e->getMessage()
            );

            $cbException->setDebug(
                array(
                    'docId'             => $id->getValue(),
                    'method'            => ClassUtil::getQualifiedMethodName(
                            $this,
                            __METHOD__,
                            true
                        ),
                    'previousException' => ExceptionUtil::exceptionAsArray(
                            $e,
                            false
                        )
                )
            );

            throw $cbException;
        }
    }

    /**
     * @param StringStrictNotEmptyType $id
     * @param ArrayAssocNotEmptyType   $document
     * @param UintType                 $expiry
     * @param string                   $cas
     * @param int                      $persistTo
     * @param int                      $replicateTo
     *
     * @return string
     * @throws CouchbaseSdkJsonException
     */
    public function set(
        StringStrictNotEmptyType $id,
        ArrayAssocNotEmptyType $document,
        UintType $expiry,
        $cas = "",
        $persistTo = 0,
        $replicateTo = 0
    )
    {
        $sdkNative = $this->getSdkNative();

        $documentText = $this->encode( $document->getValue() );

        try {
            $casValue = $sdkNative->set(
                $id->getValue(),
                $documentText,
                $expiry->getValue(),
                $cas,
                $persistTo,
                $replicateTo
            );

            $isValid = is_string( $casValue ) && ( !$casValue !== '' );
            if ( !$isValid ) {

                throw new \Exception(
                    'Method returned invalid cas value = ' . $casValue . ' ! '
                );
            }


            return $casValue;

        }
        catch (\Exception $e) {

            $cbException = new CouchbaseSdkJsonException(
                'CB Write Operation Failed! details=' . $e->getMessage()
            );

            $cbException->setDebug(
                array(
                    'docId'             => $id->getValue(),
                    'docValue'          => $document->getValue(),
                    'method'            => ClassUtil::getQualifiedMethodName(
                            $this,
                            __METHOD__,
                            true
                        ),
                    'previousException' => ExceptionUtil::exceptionAsArray(
                            $e,
                            false
                        )
                )
            );

            throw $cbException;

        }
    }


    // =========================================


    /**
     * @param string $text
     *
     * @return mixed|null
     */
    private function decode( $text )
    {
        $hasData = $text !== false;
        if ( $hasData && !is_string( $text ) ) {

            // cb internal encoding was used
            return $text;
        }

        $data = null;
        try {
            $data = json_decode( $text, true );
        }
        catch (\Exception $e) {

            // nop
        }

        if ( $data === false ) {
            if ( $text !== 'false' ) {
                $data = null;
            }
        }

        return $data;

    }

    /**
     * @param $data
     *
     * @return string
     * @throws CouchbaseSdkJsonException
     */
    private function encode( $data )
    {
        $text = null;
        try {
            $text = json_encode( $data );
        }
        catch (\Exception $e) {
            // nop
        }
        $isValid = is_string( $text ) && ( $text !== '' );
        if ( !$isValid ) {

            throw new CouchbaseSdkJsonException(
                'Failed to encode document!'
            );
        }

        return (string)$text;
    }

} 