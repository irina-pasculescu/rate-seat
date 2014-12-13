<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 5/27/13
 * Time: 12:26 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Lib\Rpc\JsonRpc\Utils;

/**
 * Class SignedRequestUtil
 *
 * @package Application\Lib\Rpc\JsonRpc\Utils
 */
class SignedRequestUtil
{


    /**
     * @param $data
     * @param $signKeys
     * @param $appSecret
     * @param \DateTime $issuedAt
     * @param string $signedRequestAlgorithm
     * @return string
     */
    public static function createRequestSignature(

        $data,
        $signKeys,
        $appSecret,
        \DateTime $issuedAt,
        $signedRequestAlgorithm = 'HMAC-SHA256'

    ) {
        if (!is_array($data)) {
            $data = array();
        }
        if (!is_array($signKeys)) {
            $signKeys = array();
        }

        $signedRequestAlgorithm = strtoupper($signedRequestAlgorithm);

        $dataNew = array();
        foreach ($signKeys as $key) {
            $value = null;
            if (array_key_exists($key, $data)) {
                $value = $data[$key];
            }
            $dataNew[$key] = $value;
        }
        $data = $dataNew;

        // sort keys
        uksort($data, 'strcmp');

        $json = (string)self::jsonEncode($data, false);

        $signatureParts
            = array(
            (string)strtoupper($signedRequestAlgorithm),
            (string)$issuedAt->getTimestamp(),
            (string)self::base64UrlEncodeUrlSafe($json),
        );

        $b64Data = self::base64UrlEncodeUrlSafe(
            implode(
                '.',
                $signatureParts
            )
        );
        switch ($signedRequestAlgorithm) {
            case 'MD5':
            {
                $rawSig = md5((string)$b64Data . '' . $appSecret);

                break;
            }
            case 'HMAC-SHA256':
            case 'SHA256':
            {
                $rawSig = hash_hmac(
                    'sha256',
                    $b64Data,
                    $appSecret,
                    true
                );

                break;

            }
            default:
                $rawSig = hash_hmac(
                    $signedRequestAlgorithm,
                    $b64Data,
                    $appSecret,
                    true
                );

                break;

        }


        $sig = (string)implode(
            '.',
            array(
                $signatureParts[0],
                $signatureParts[1],
                $rawSig,
            )
        );

        $sig = (string)self::base64UrlEncodeUrlSafe($sig);

        return $sig;

    }

    /**
     * @param string $signature
     * @param array $data
     * @param array $signKeys
     * @param string $appSecret
     * @param string $signedRequestAlgorithm
     *
     * @return bool
     */
    public static function validateSignedRequest(
        $signature = '',
        $data,
        $signKeys,
        $appSecret,
        $signedRequestAlgorithm = 'HMAC-SHA256'
    ) {

        $result = false;

        if (!is_string($signature)) {

            return $result;
        }

        $sigGiven = $signature;
        $sigDecoded = self::base64UrlDecodeUrlSafe($sigGiven);

        list(
            $algorithmGiven,
            $issuedAtGiven,
            $rawSigGiven
            )
            = explode('.', $sigDecoded, 3);

        if (!is_string($algorithmGiven)) {

            return $result;
        }

        if (!is_string($issuedAtGiven)) {

            return $result;
        }

        if (!is_string($rawSigGiven)) {

            return $result;
        }

        $issuedAtGiven = (int)$issuedAtGiven;
        if ($issuedAtGiven < 0) {
            $issuedAtGiven = 0;
        }
        $signedRequestAlgorithm = strtoupper($signedRequestAlgorithm);
        $algorithmGiven = strtoupper($signedRequestAlgorithm);

        if ($algorithmGiven !== $signedRequestAlgorithm) {

            return $result;
        }

        if (!is_array($data)) {
            $data = array();
        }
        if (!is_array($signKeys)) {
            $signKeys = array();
        }

        $issuedAtGivenDateTime = new \DateTime();
        $issuedAtGivenDateTime->setTimestamp($issuedAtGiven);

        $signatureExpected = self::createRequestSignature(
            $data,
            $signKeys,
            $appSecret,
            $issuedAtGivenDateTime,
            $signedRequestAlgorithm
        );

        $result = ($signatureExpected === $sigGiven);

        return $result;
    }


    /**
     * @param mixed $value
     * @param bool $marshallExceptions
     *
     * @return null|string
     * @throws \Exception
     */
    private static function jsonEncode(
        $value,
        $marshallExceptions
    ) {
        $marshallExceptions = ($marshallExceptions === true);

        $result = null;
        try {
            $result = json_encode($value);
        } catch (\Exception $e) {
            $result = null;
            if ($marshallExceptions) {

                // delegate exception
                throw $e;
            }
        }

        if (!is_string($result)) {
            $result = null;
        }

        return $result;

    }

    /**
     * @see: facebook-php-sdk
     * Base64 encoding that doesn't need to be urlencode()ed.
     * Exactly the same as base64_encode except it uses
     *   - instead of +
     *   _ instead of /
     *   No padded =
     *
     * @param string $input base64UrlEncoded string
     *
     * @return string
     */
    private static function base64UrlDecodeUrlSafe($input)
    {

        return base64_decode(strtr($input, '-_', '+/'));
    }

    /**
     * @see: facebook-php-sdk
     * Base64 encoding that doesn't need to be urlencode()ed.
     * Exactly the same as base64_encode except it uses
     *   - instead of +
     *   _ instead of /
     *
     * @param string $input string
     *
     * @return string base64Url encoded string
     */
    private static function base64UrlEncodeUrlSafe($input)
    {
        $str = strtr(base64_encode($input), '+/', '-_');
        $str = str_replace('=', '', $str);

        return $str;
    }


}