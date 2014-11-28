<?php

/**
 * Description of phone
 *
 * @author Arian Khosravi <arian@bigemployee.com>, <@ArianKhosravi>
 */
class BigContact_Models_Phone {

    protected $_id;
    protected $_label;
    protected $_number;


    public function __construct(array $options = null) {
        if (is_array($options))
            $this->setOptions($options);
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if ('mapper' == $name || !method_exists($this, $method))
            return new Exception('Invalid Models_Phone method ' . $method);
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if ('mapper' == $name || !method_exists($this, $method))
            return new Exception('Invalid Models_Phone method ' . $method);
        return $this->$method();
    }

    public function setOptions(array $options = null) {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods))
                $this->$method($value);
        }
        return $this;
    }

    public function setId($id) {
        $this->_id = $id;
        return $this;
    }

    public function getId() {
        return $this->_id;
    }

    public function setLabel($label) {
        $this->_label = $label;
        return $this;
    }

    public function getLabel() {
        return $this->_label;
    }

    public function setNumber($number) {
        $this->_number = $number;
        return $this;
    }

    public function getNumber() {
        return $this->_number;
    }

}