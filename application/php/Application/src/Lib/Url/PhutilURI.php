<?php
/**
 *
 * Basic URI parser object.
 * see: https://raw.github.com/facebook/libphutil/master/src/parser/PhutilURI.php
 *
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 12/13/12
 * Time: 5:05 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Lib\Url;

/**
 * Class PhutilURI
 * @package Application\Lib\Url
 */
class PhutilURI
{

    private $protocol;
    private $user;
    private $pass;
    private $domain;
    private $port;
    private $path;
    private $query = array();
    private $fragment;

    public function __construct( $uri )
    {
        $parts = $this->parseURI( $uri );
        if ( $parts ) {
            $this->protocol = $parts[ 1 ];
            $this->user     = $parts[ 2 ];
            $this->pass     = $parts[ 3 ];
            $this->domain   = $parts[ 4 ];
            $this->port     = $parts[ 5 ];
            $this->path     = $parts[ 6 ];
            parse_str( $parts[ 7 ], $this->query );
            $this->fragment = $parts[ 8 ];
        }
    }

    private static function parseURI( $uri )
    {
        // NOTE: We allow "+" in the protocol for "svn+ssh" and similar.
        $protocol = '([\w+]+):\/\/';
        $auth     = '(?:([^:@]+)(?::([^@]+))?@)?';
        $domain   = '([a-zA-Z0-9\.\-_]*)';
        $port     = '(?::(\d+))?';
        $path     = '((?:\/|^)[^#?]*)?';
        $query    = '(?:\?([^#]*))?';
        $anchor   = '(?:#(.*))?';

        $regexp = '/^(?:' . $protocol . $auth . $domain . $port . ')?' .
                  $path . $query . $anchor . '$/S';

        $matches = null;
        $ok      = preg_match( $regexp, $uri, $matches );
        if ( $ok ) {
            return array_pad( $matches, 9, '' );
        }

        return null;
    }

    public function __toString()
    {
        $prefix = null;
        if ( $this->protocol || $this->domain || $this->port ) {
            $protocol = self::nonempty( $this->protocol, 'http' );

            $auth = '';
            if ( $this->user && $this->pass ) {
                $auth = $this->user . ':' . $this->pass . '@';
            }
            else {
                if ( $this->user ) {
                    $auth = $this->user . '@';
                }
            }

            $prefix = $protocol . '://' . $auth . $this->domain;
            if ( $this->port ) {
                $prefix .= ':' . $this->port;
            }
        }

        if ( $this->query ) {
            $query = '?' . http_build_query( $this->query );
        }
        else {
            $query = null;
        }

        if ( strlen( $this->getFragment() ) ) {
            $fragment = '#' . $this->getFragment();
        }
        else {
            $fragment = null;
        }

        return $prefix . $this->getPath() . $query . $fragment;
    }

    public function setQueryParam( $key, $value )
    {
        if ( $value === null ) {
            unset( $this->query[ $key ] );
        }
        else {
            $this->query[ $key ] = $value;
        }

        return $this;
    }

    public function setQueryParams( array $params )
    {
        $this->query = $params;

        return $this;
    }

    public function getQueryParams()
    {
        return $this->query;
    }

    public function setProtocol( $protocol )
    {
        $this->protocol = $protocol;

        return $this;
    }

    public function getProtocol()
    {
        return $this->protocol;
    }

    public function setDomain( $domain )
    {
        $this->domain = $domain;

        return $this;
    }

    public function getDomain()
    {
        return $this->domain;
    }

    public function setPort( $port )
    {
        $this->port = $port;

        return $this;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function setPath( $path )
    {
        $this->path = $path;

        return $this;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setFragment( $fragment )
    {
        $this->fragment = $fragment;

        return $this;
    }

    public function getFragment()
    {
        return $this->fragment;
    }

    public function setUser( $user )
    {
        $this->user = $user;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setPass( $pass )
    {
        $this->pass = $pass;

        return $this;
    }

    public function getPass()
    {
        return $this->pass;
    }

    public function alter( $key, $value )
    {
        $altered = clone $this;
        $altered->setQueryParam( $key, $value );

        return $altered;
    }

    /**
     * Similar to @{function:coalesce}, but less strict: returns the first
     * non-##empty()## argument, instead of the first argument that is strictly
     * non-##null##. If no argument is nonempty, it returns the last argument. This
     * is useful idiomatically for setting defaults:
     *
     *   $display_name = nonempty($user_name, $full_name, "Anonymous");
     *
     * @param  ...         Zero or more arguments of any type.
     *
     * @return mixed       First non-##empty()## arg, or last arg if no such arg
     *                     exists, or null if you passed in zero args.
     * @group  util
     */
    protected static function nonempty( /* ... */ )
    {
        $args   = func_get_args();
        $result = null;
        foreach ( $args as $arg ) {
            $result = $arg;
            if ( $arg ) {
                break;
            }
        }

        return $result;
    }

}


