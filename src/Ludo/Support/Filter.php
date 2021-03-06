<?php
namespace Ludo\Support;

class Filter
{
    /**
     * Sanitize int data
     *
     * @param String $data
     * @return int value
     */
    public static function int($data)
    {
        return filter_var($data, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * Sanitize float data
     *
     * @param String $data
     * @return float value
     */
    public static function float($data)
    {
        return filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT);
    }

    /**
     * Sanitize Email string
     *
     * @param String $data url string
     * @return string clean url string
     */
    public static function email($data)
    {
        return filter_var(trim($data), FILTER_SANITIZE_EMAIL);
    }

    /**
     * Sanitize  URL string
     *
     * @param String $data url string
     * @return string clean url string
     */
    public static function url($data)
    {
        return filter_var(trim($data), FILTER_SANITIZE_URL);
    }

    /**
     * Sanitize the String to escape all html tags to HTML entities.
     *
     * @param String $data
     * @param int $encodeType ENT_QUOTES or ENT_NOQUOTES  or ENT_COMPAT. Default is ENT_QUOTES
     * @return string the clean string with no html tags.
     */
    public static function str($data, $encodeType = ENT_QUOTES)
    {
        //make sure data with MB encoding have a correct/safe format.
        //prevent any <a href="http://ha.ckers.org/charsets.html">variable width encoding attacks</a>
        $data = mb_convert_encoding($data, PROGRAM_CHARSET, PROGRAM_CHARSET);
        return htmlspecialchars(trim($data), $encodeType, PROGRAM_CHARSET);
    }

    /**
     * Sanitize the String to escape all html tags and non-ascii strings to HTML entities.
     *
     * @param String $data
     * @param int $encodeType ENT_QUOTES or ENT_NOQUOTES  or ENT_COMPAT. Default is ENT_QUOTES
     * @return string the clean string with no html tags.
     */
    public static function entity($data, $encodeType = ENT_QUOTES)
    {
        //make sure data with MB encoding have a correct/safe format.
        //prevent any <a href="http://ha.ckers.org/charsets.html">variable width encoding attacks</a>
        $data = mb_convert_encoding($data, PROGRAM_CHARSET, PROGRAM_CHARSET);
        return htmlentities(trim($data), $encodeType, PROGRAM_CHARSET);
    }

    /**
     * Sanitize the html tags against XSS exploit
     *
     * @param String $dirtyHtml html string needs to be sanitized.
     * @param String $allowedTags eg. 'p,b,a[href],i'
     * @return string clean html string
     */
    public static function html($dirtyHtml, $allowedTags = '')
    {
        $config = \HTMLPurifier_Config::createDefault();
        $config->set('Core.Encoding', PROGRAM_CHARSET);
        $config->set('Cache.SerializerPath', LD_UPLOAD_TMP_PATH);
        if ($allowedTags) $config->set('HTML.Allowed', $allowedTags);

        $purifier = new \HTMLPurifier($config);
        return $purifier->purify(trim($dirtyHtml));
    }
}
