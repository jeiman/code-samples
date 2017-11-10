<?php
/**
 * User: Jeiman
 * Date: 22-Apr-17
 * Time: 3:36 AM
 *
 * Http library for HTTP needs
 *
 */

/** Adds http to domains that dont have one **/
function addHttp ($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}

// Filters Url to grab the hostname of the URL parsed.
function getUrlHostname ($url) {
    $url = parse_url($url, PHP_URL_HOST);

    return $url;
}

?>