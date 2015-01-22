<?php

class Widget
{
    /**
     * [title] => Rajče.net › sdh-zabori › Nejnovější alba uživatele
     * return: sdh-zabori
     * @param $title
     * @return string
     */
    public static function getGalleryUser( $title )
    {
        $titleArray = explode( " › ", $title );
        if( isset( $titleArray[1] ) )
        {
            return $titleArray[1];
        }
        else
        {
            return FALSE;
        }
    }
}