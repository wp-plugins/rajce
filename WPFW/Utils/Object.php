<?php

namespace WPFW\Utils;

class Object
{

    /** @var array */
    private $memory = array();


    public function __get($name)
    {
        if( $this->__isset($name) )
        {
            return $this->memory[$name];
        }
        else
        {
            return NULL;
        }
    }

    public function __set($name, $value)
    {
        $this->memory[$name] = $value;
    }

    public function __isset($name)
    {
        return isset($this->memory[$name]);
    }

    public function __unset($name)
    {
        unset( $this->memory[$name] );
    }

}