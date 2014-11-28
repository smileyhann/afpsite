<?php

if (!function_exists('Functions_GetMessages')) {

    function Functions_GetMessages($messages, $message_type) {
        $str = '';
        if (count($messages) > 0) {
            if ($message_type == 'error') {
                $str .= '<div class="error"><p>';
                foreach ($messages as $message)
                    $str.= $message . '<br>';
                $str .= '</p></div>';
            } elseif ($message_type == 'update') {
                $str .= '<div class="updated"><p>';
                foreach ($messages as $message)
                    $str .= $message . '<br>';
                $str .= '</p></div>';
            } elseif ($message_type == 'success') {
                $str .= '<div id="message" class="success"><p>';
                foreach ($messages as $message)
                    $str .= $message . '<br>';
                $str .= '</p></div>';
            }
        }
        return $str;
    }

}
if (!function_exists("Functions_GetJQueryUiStyles")) {

    function Functions_GetJQueryUiStyles() {
        $path = BIGCONTACT_PATH.DIRECTORY_SEPARATOR.'view'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR;
        $url = BIGCONTACT_URL.'view/css/';
        $styles = array();
        $formats = array('css');
        if ($handle = opendir($path)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    if (is_dir($path . $entry) && $sub_handle = opendir($path . $entry)) {
                        while (false !== ($sub_entry = readdir($sub_handle))) {
                            if ($sub_entry != "." && $sub_entry != "..") {
                                if (in_array(strtolower(substr($sub_entry, -3)), $formats)) {
                                    $styles[] = new JQueryUiStyle(
                                                    array(
                                                        'name' => $entry,
                                                        'path' => $url . $entry . '/' . $sub_entry
                                            ));
                                }
                            }
                        }
                        closedir($sub_handle);
                    }
                }
            }
            closedir($handle);
        }
        return $styles;
    }

}

class JQueryUiStyle {

    protected $_name;
    protected $_path;

    function __construct(array $options = null) {
        if (is_array($options))
            $this->setOptions($options);
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if ('mapper' == $name && !method_exists($this, $method))
            return new Exception('Invalid jQueryUiStyle function');
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name();
        if ('mapper' == $name && !method_exists($this, $method))
            return new Exception('Invalid jQueryUiStyle function');
        return $this->$method();
    }

    public function setOptions(array $options = NULL) {
        $methods = get_class_methods($this);
        foreach ($options as $name => $value) {
            $method = 'set' . ucfirst($name);
            if (in_array($method, $methods))
                $this->$method($value);
        }
        return $this;
    }

    function setName($_name) {
        $this->_name = $_name;
        return $this;
    }

    function getName() {
        return $this->_name;
    }

    function setPath($_path) {
        $this->_path = $_path;
        return $this;
    }

    function getPath() {
        return $this->_path;
    }

}