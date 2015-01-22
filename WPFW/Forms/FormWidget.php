<?php

namespace WPFW\Forms;

include_once "Container.php";

class FormWidget extends Container
{

    function __construct()
    {

    }

    public function isSuccess()
    {
        if( count($_POST) > 0 )
        {

            foreach( $this->getControls() as $control )
            {
                if($control->isOmitted() == TRUE )
                {
                    //send
                    if( array_key_exists( $control->getHtmlName(), $_POST) && $_POST[$control->getHtmlName()] == $control->getLabel() )
                    {
                        return TRUE;
                    }
                }
            }

        }

        return FALSE;

    }

    /**
     * Renders form to string.
     * @return can throw exceptions? (hidden parameter)
     * @return string
     */
    public function __toString()
    {
        //echo "<form action=\"" . esc_url( $_SERVER['REQUEST_URI'] ) . "\" method=\"post\">";
        foreach( $this->getControls() as $control )
        {
            //print_r( $control );
            $control->getControl();
            //echo "<hr/>";
        }
        //echo "</form>";

        return "";
    }

}