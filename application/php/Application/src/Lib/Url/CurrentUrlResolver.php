<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 3/22/13
 * Time: 10:39 AM
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Lib\Url;

/**
 * Class CurrentUrlResolver
 *
 * @package Application\Lib\Url
 */
class CurrentUrlResolver
{

    /**
     * Indicates if we trust HTTP_X_FORWARDED_* headers.
     *
     * @var boolean
     */
    private $trustForwarded = false;

    /**
     * @var PhutilURI
     */
    private $uriParsed;

    /**
     * @var self
     */
    private static $instance;

    /**
     * @return self
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return PhutilURI
     */
    public function getUriParsed()
    {
        if (!($this->uriParsed instanceof PhutilURI)) {

            $url = $this->detectCurrentUrl();
            $this->uriParsed = new PhutilURI($url);

        }

        return $this->uriParsed;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        $uriParsed = $this->getUriParsed();

        $url = (string)$uriParsed;

        return $url;
    }

    /**
     * For mocking: use that method
     *
     * @param PhutilURI $uriParsed
     *
     * @return self
     */
    public function setUriParsed(PhutilURI $uriParsed)
    {
        $this->uriParsed = $uriParsed;

        return $this;
    }


    // =========== helpers: from php-facebook-sdk ==================
    /**
     * @return mixed
     */
    private function getHttpHost()
    {
        if ($this->trustForwarded && isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
            return $_SERVER['HTTP_X_FORWARDED_HOST'];
        }

        return $_SERVER['HTTP_HOST'];
    }

    /**
     * @return string
     */
    private function getHttpProtocol()
    {
        if ($this->trustForwarded && isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            if ($_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
                return 'https';
            }

            return 'http';
        }
        if (isset($_SERVER['HTTPS'])
            && ($_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] == 1)
        ) {
            return 'https';
        }

        return 'http';
    }

    /**
     * Returns the Current URL, stripping it of known FB parameters that should
     * not persist.
     *
     * @return string The current URL
     */
    private function detectCurrentUrl()
    {
        $protocol = $this->getHttpProtocol() . '://';
        $host = $this->getHttpHost();
        $currentUrl = $protocol . $host . $_SERVER['REQUEST_URI'];
        $parts = parse_url($currentUrl);

        $query = '';
        if (!empty($parts['query'])) {
            // drop known fb params
            $params = explode('&', $parts['query']);
            $retainedParams = $params;

            if (!empty($retainedParams)) {
                $query = '?' . implode($retainedParams, '&');
            }
        }

        // use port if non default
        $port = '';
        if (isset($parts['port'])) {
            if (($protocol === 'http://' && $parts['port'] !== 80) ||
                ($protocol === 'https://' && $parts['port'] !== 443)
            ) {
                $port = ':' . $parts['port'];
            }
        }

        // rebuild
        return $protocol . $parts['host'] . $port . $parts['path'] . $query;
    }


}
