<?php

namespace WPFW\Forms\Controls;

use WPFW\Forms\IControl;
use WPFW\Utils\Strings;

class BaseControl implements IControl
{
    /** @var mixed if of control */
    protected $id;

    /** @var mixed name of control */
    protected $name;

    /** @var mixed label of control */
    protected $label;

    /** @var mixed control value */
    protected $value;

    /** @var bool */
    protected $disabled = FALSE;

    /** @var bool Is control value excluded from $form->getValues() result? */
    private $omitted = FALSE;

    protected $control;

    /** @var array user options */
    private $options = array();

    /**
     * @param $id
     * @param $name
     * @param null $label
     */
    public function __construct( $id, $name, $label = NULL )
    {
        $this->id = $id;
        $this->name = $name;
        $this->label = $label;
        $this->control = new \WPFW\Utils\Object();
        $this->setValue(NULL);
    }

    /**
     * Returns control id
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets control name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Returns control name
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns control Html name
     * @return mixed
     */
    public function getHtmlName()
    {
        //return Strings::webalize( $this->name );
        return $this->name;
    }

    /**
     * Sets control value
     * @return self
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Returns control value.
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Returns label
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Disables or enables control
     * @param  bool
     * @return self
     */
    public function setDisabled($value = TRUE)
    {
        if ($this->disabled = (bool) $value) {
            $this->omitted = TRUE;
        }
        return $this;
    }


    /**
     * Is control disabled?
     * @return bool
     */
    public function isDisabled()
    {
        return $this->disabled === TRUE;
    }

    /**
     * Sets whether control value is excluded from $form->getValues() result.
     * @param  bool
     * @return self
     */
    public function setOmitted($value = TRUE)
    {
        $this->omitted = (bool) $value;
        return $this;
    }
    /**
     * Is control value excluded from $form->getValues() result?
     * @return bool
     */
    public function isOmitted()
    {
        return $this->omitted;
    }

    /* ******************** user data ***************** */


    /**
     * Set option
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
     * Get option
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

} 