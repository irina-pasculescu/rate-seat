<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/8/14
 * Time: 12:26 PM
 */

namespace Application\Utils;

/**
 * Class DateUtil
 *
 * @package Application\Utils
 */
class DateUtil
{


    const TIMEZONE_NAME_UTC = 'UTC';

    /**
     * @param $date
     * @param $now
     *
     * @return \DateTime
     * @throws \InvalidArgumentException
     */
    public static function createDateTime(
        $date,
        $now
    )
    {
        $isValid = is_int( $now ) && ( $now >= 0 );
        if ( !$isValid ) {

            throw new \InvalidArgumentException(
                'Invalid parameter "now" !'
            );
        }

        $timestampDefault = 0;
        $dateTime         = new \DateTime();

        $dateTime->setTimestamp( $timestampDefault );
        $isIntString = is_string( $date )
                       && is_numeric( $date )
                       && ( (string)(int)$date === $date
            );
        if ( $isIntString ) {
            $date = (int)$date;
        }
        if ( is_int( $date ) ) {
            try {
                if ( $date > 0 ) {
                    $dateTime->setTimestamp( $date );
                }
            }
            catch (\Exception $e) {
                $dateTime->setTimestamp( $timestampDefault );
            }

            return $dateTime;
        }

        if ( is_string( $date ) ) {
            if (
                ( empty( $date ) ) || ( trim( $date ) === '' )
            ) {

                return $dateTime;
            }

            if ( trim( strtolower( $date ) === 'now' ) ) {

                $dateTime->setTimestamp( $now );

                return $dateTime;
            }


            try {
                $dateTime = new \DateTime(
                    $date
                );

                return $dateTime;

            }
            catch (\Exception $e) {
                // nop
            }

        }

        $dateTime = new \DateTime();

        $dateTime->setTimestamp( $timestampDefault );

        return $dateTime;
    }

    /**
     * @param \DateTime $dateTime
     * @param string    $timezoneName
     *
     * @return \DateTime
     */
    public static function toLocalDateTime(
        \DateTime $dateTime,
        $timezoneName = ''
    )
    {
        $now        = 0;
        $dateString = $dateTime->format( DATE_ISO8601 );

        $hasTimeZoneName = !(
            ( $timezoneName === null ) || ( trim( $timezoneName ) === '' )
        );
        if ( !$hasTimeZoneName ) {
            $timezoneName = self::getDateTimeZoneNameDefault();
        }

        $finalDateTime = self::createDateTime( $dateString, $now );
        $finalDateTime->setTimezone(
            new \DateTimeZone( $timezoneName )
        );

        return $finalDateTime;
    }


    /**
     * @param \DateTime $dateTime
     *
     * @return \DateTime
     */
    public static function toUtcDateTime( \DateTime $dateTime )
    {
        return self::toLocalDateTime( $dateTime, self::TIMEZONE_NAME_UTC );
    }


    /**
     * @return string
     */
    public static function getDateTimeZoneNameDefault()
    {
        return date_default_timezone_get();
    }

} 