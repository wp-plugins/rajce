<?php

namespace WPFW\Forms;

class Container implements \ArrayAccess
{

    /** @var IControl[] */
    private $controls = array();

    /** @var ControlGroup */
    protected $currentGroup;

    /**
     * Values submitted by the form.
     * @param  bool  return as array?
     */
    public function getValues($asArray = FALSE)
    {
        $a = array();
        foreach( $this->getControls() as $control )
        {
            if($control->isOmitted() == FALSE )
            {
                if(array_key_exists($control->getHtmlName(), $_POST))
                {
                    $a[$control->getHtmlName()] = $_POST[$control->getHtmlName()];
                }
                else
                {
                    echo $control->getHtmlName() . " neni v postu <br/>";
                    $a[$control->getHtmlName()] = NULL;
                }
            }
        }

        return $a;
    }

    /**
     * Set current group
     * @return self
     */
    public function setCurrentGroup(ControlGroup $group = NULL)
    {
        $this->currentGroup = $group;
        return $this;
    }


    /**
     * Return current group
     * @return ControlGroup
     */
    public function getCurrentGroup()
    {
        return $this->currentGroup;
    }

    /**
     * Adds input
     * @param  string  control name
     * @param  string  label
     */
    public function addText($id, $name, $label = NULL, $maxLength = NULL)
    {
        $control = new Controls\TextInput($id, $name, $label, $maxLength);
        return $this[$name] = $control;
    }

    /**
     * Adds check box
     * @param  string  control name
     * @param  string  caption
     */
    public function addCheckbox($id, $name, $caption = NULL)
    {
        $control = new Controls\Checkbox($id, $name, $caption);
        return $this[$name] = $control;
    }

    /**
     * Button used to submit form
     * @param  string  control name
     * @param  string  caption
     */
    public function addSubmit($name, $caption = NULL)
    {
        $control = new Controls\SubmitButton( $name, $caption);
        return $this[$name] = $control;
    }

    public function getControls()
    {
        return $this->controls;
    }

    /* ******************** interface \ArrayAccess ***************** */

    /**
     * Adds control
     * @param  Control
     * @param  string
     * @return self
     */
    public function addComponent(\WPFW\Forms\IControl $control, $name)
    {
        if ($this->currentGroup !== NULL) {
            $this->currentGroup->add($control);
        }
        else
        {
            $this->controls[] = $control;
        }
        return $this;

    }

    /**
     * Adds the component to the container.
     * @param  string  component name
     * @param  Nette\ComponentModel\IComponent
     * @return void
     */
    public function offsetSet($name, $control)
    {
        $this->addComponent($control, $name);
    }


    public function offsetGet($name)
    {
        //return $this->getComponent($name, TRUE);
    }


    public function offsetExists($name)
    {
        //return $this->getComponent($name, FALSE) !== NULL;
    }


    public function offsetUnset($name)
    {
        /*$component = $this->getComponent($name, FALSE);
        if ($component !== NULL) {
            $this->removeComponent($component);
        }*/
    }

} 