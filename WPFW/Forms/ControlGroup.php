<?php

namespace WPFW\Forms;


class ControlGroup
{
    /** @var IControl[] */
    protected $controls = array();

    /** @var array user options */
    private $options = array();

    /**
     * @return self
     */
    public function add( \WPFW\Forms\IControl $control )
    {
        $this->controls[] = $control;
        return $this;
    }

    /**
     * Sets user-specific option.
     * Options recognized by DefaultFormRenderer
     * - 'label' - textual or Html object label
     * - 'description' - textual or Html object description
     *
     * @param  string key
     * @param  mixed  value
     * @return self
     */
    public function setOption($key, $value)
    {
        if ($value === NULL) {
            unset($this->options[$key]);
        } else {
            $this->options[$key] = $value;
        }
        return $this;
    }


    /**
     * Returns user-specific option.
     * @param  string key
     * @param  mixed  default value
     * @return mixed
     */
    public function getOption($key, $default = NULL)
    {
        return isset($this->options[$key]) ? $this->options[$key] : $default;
    }
    /**
     * Returns user-specific options.
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Get controls from Group
     * @return array IControl[]
     */
    public function getControls()
    {
        return $this->controls;
    }

    /**
     * Get label
     * @return string
     */
    public function getLabel()
    {
        return $this->getOption( "label", NULL );
    }

}