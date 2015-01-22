<?php

namespace WPFW\Forms\Controls;

class TextInput extends BaseControl
{


    public function __construct( $id, $name, $label = NULL, $maxLength = NULL )
    {
        parent::__construct( $id, $name, $label );
        $this->control->type = 'text';
        $this->control->maxlength = $maxLength;
    }

    /**
     * Generates HTML control
     * @return string
     */
    public function getControl()
    {
        $s = "<table class=\"form-table\">
            <tbody>
                <tr>
                    <th scope=\"row\"><label for=\"" . $this->getHtmlName() . "\">".$this->getLabel()."</label></th>
                    <td><input name=\"" . $this->getHtmlName() . "\" type=\"text\" id=\"" . $this->getId() . "\" value=\"".$this->getValue()."\" class=\"regular-text\"";
                    if( $this->isDisabled() )
                    {
                        $s .= " disabled";
                    }
                    $s .= "></td>
                </tr>
            </tbody>
        </table>";

        return $s;
    }

} 