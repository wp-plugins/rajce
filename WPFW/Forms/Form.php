<?php

namespace WPFW\Forms;

use WPFW\Forms\ControlGroup;

include_once "Container.php";

class Form extends Container
{

    /** @var ControlGroup[] */
    private $groups = array();

    function __construct()
    {

    }

    /**
     * Add fieldset group to the form
     * @param  string  caption
     * @param  bool    set this group as current
     * @return ControlGroup
     */
    public function addGroup($caption = NULL)
    {
        $group = new ControlGroup;
        $group->setOption('label', $caption);

        $this->setCurrentGroup($group);

        if (!is_scalar($caption) || isset($this->groups[$caption])) {
            return $this->groups[] = $group;
        } else {
            return $this->groups[$caption] = $group;
        }
    }

    /**
     * Returns all form groups
     * @return ControlGroup[]
     */
    public function getGroups()
    {
        return $this->groups;
    }


    /**
     * Returns specified group
     * @param  string  name
     * @return ControlGroup
     */
    public function getGroup($name)
    {
        return isset($this->groups[$name]) ? $this->groups[$name] : NULL;
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
        $s = "<form action=\"" . esc_url( $_SERVER['REQUEST_URI'] ) . "\" method=\"post\">";

        foreach( $this->getGroups() as $group )
        {
            $s .= "<fieldset>
                <legend>" . $group->getLabel() . "</legend>";
            foreach( $group->getControls() as $control )
            {
                $s .= $control->getControl();
            }
            $s .= "</fieldset>";
        }

        foreach( $this->getControls() as $control )
        {
            $s .= $control->getControl();
        }
        $s .= "</form>";

        return $s;
    }

}