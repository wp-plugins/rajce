<?php

namespace WPFW\Utils;


class Xml
{

    /**
     * Parse XML on URL to array
     * @param $url
     * @return mixed
     */
    public static function parseXMLtoArray( $url )
    {
        //ini_set('memory_limit', '4G');
        //echo "Loading feed: <strong>" . $url ."</strong><br/>";

        $xmlFeed = file_get_contents( $url );

        $xml = simplexml_load_string($xmlFeed);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);

        return $array;
    }

}