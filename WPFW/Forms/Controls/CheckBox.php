<?php

namespace WPFW\Forms\Controls;

class CheckBox extends BaseControl
{


    public function __construct( $id, $name, $label = NULL )
    {
        parent::__construct( $id, $name, $label );
        $this->control->type = 'checkbox';
    }

    /**
     * Generates HTML control
     * @return string
     */
    public function getControl()
    {
        $s="<table class=\"form-table\">
            <tbody>
                <tr>
                    <th scope=\"row\">".$this->getLabel()."</th>
                    <td><input type=\"checkbox\" name=\"" . $this->getHtmlName() . "\" value=\"true\" ";
                    if($this->value == TRUE)
                    {
                        $s.="checked";
                    }
                    $s.="/><small>".$this->getOption('description')."</small></td>
                </tr>
            </tbody>
        </table>";

        return $s;
    }

} 