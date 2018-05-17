<?php

namespace Uaitec\Model;

abstract class AbstractModel {

    /**
     * Magic getter to expose protected properties.
     * 
     * @param string $property        	
     * @return mixed
     */
    public function __get($property) {
        return $this->$property;
    }

    /**
     * Magic setter to save protected properties.
     *
     * @param string $property        	
     * @param mixed $value        	
     */
    public function __set($property, $value) {
        $this->$property = $value;
    }

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy() {
        return get_object_vars($this);
    }

    /**
     * Populate from an array.
     *
     * @param array $data        	
     */
    public function populate($data = array()) {

        foreach ($data as $attribute => $value) {
            $this->$attribute = $value;
        }
    }

}
