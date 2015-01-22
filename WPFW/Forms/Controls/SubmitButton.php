<?php

namespace WPFW\Forms\Controls;


class SubmitButton extends BaseControl
{

    public function __construct($name, $caption = NULL)
    {
        parent::__construct( $name, $caption );
        $this->control->type = 'button';
        $this->setOmitted( TRUE );
    }

    /**
     * Generates HTML control
     * @return string
     */
    public function getControl($caption = NULL)
    {
        return "<p class=\"submit\"><input type=\"submit\" name=\"" . $this->getHtmlName() . "\" id=\"" . $this->getHtmlName() . "\" class=\"button button-primary\" value=\"" . $this->getLabel() . "\"></p>";
    }

} 