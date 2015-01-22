<?php

namespace WPFW\Forms;

/**
 * interface for control
 */
interface IControl
{

    /**
     * Set control value
     * @param  mixed
     * @return void
     */
    function setValue($value);

    /**
     * Return control value.
     * @return mixed
     */
    function getValue();

}