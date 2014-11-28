<?php

/**
 * Description of email
 *
 * @author Arian Khosravi <arian@bigemployee.com>, <@ArianKhosravi>
 */
class BigContact_Models_Email {

    protected $_id;
    protected $_label;
    protected $_address;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if ('mapper' == $name || !method_exists($this, $method))
            throw new Exception('Invalid contact method ' . $method);

        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if ('mapper' == $name || !method_exists($this, $method))
            throw new Exception('Invalid contact method ' . $method);

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

    public function setAddress($address) {
        $this->_address = $address;
        return $this;
    }

    public function getAddress() {
        return $this->_address;
    }

    public function getEncodedAddress() {
        $encodedAddress= '';
        for ($i = 0; $i < strlen($this->_address); $i++) {
            $encodedAddress .= '&#' . ord($this->_address[$i]) . ';';
        }
        return $encodedAddress;
    }

}