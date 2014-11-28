<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of form
 *
 * @author Arian Khosravi <arian@bigemployee.com>, <@ArianKhosravi>
 */
class BigContact_Models_Form {

    protected $_id;
    protected $_formTitle;
    protected $_telTitle;
    protected $_emailTitle;
    protected $_hoursTitle;
    protected $_mapTitle;
    protected $_nameLabel;
    protected $_emailLabel;
    protected $_phoneLabel;
    protected $_extraLabel;
    protected $_messageLabel;
    protected $_appointmentText;
    protected $_sendMail;
    protected $_monFrom;
    protected $_tueFrom;
    protected $_wedFrom;
    protected $_thuFrom;
    protected $_friFrom;
    protected $_satFrom;
    protected $_sunFrom;
    protected $_mapDescription;
    protected $_mapObject;
    protected $_address;

    public function __construct(array $options = null) {
        if (is_array($options))
            $this->setOptons($options);
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if ('mapper' == $name || !method_exists($this, $method))
            return new Exception('Invalid Form function ' . $method);
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if ('mapper' == $name || !method_exists($this, $method))
            return new Exception('Invalid Form Function ' . $method);
        return $this->$method();
    }

    public function setOptons(array $options) {
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

    public function setForm_title($title) {
        $this->_formTitle = $title;
        return $this;
    }

    public function getForm_title() {
        return $this->_formTitle;
    }

    public function setTel_title($title) {
        $this->_telTitle = $title;
        return $this;
    }

    public function getTel_title() {
        return $this->_telTitle;
    }

    public function setEmail_title($title) {
        $this->_emailTitle = $title;
        return $this;
    }

    public function getEmail_title() {
        return $this->_emailTitle;
    }

    public function setHours_title($title) {
        $this->_hoursTitle = $title;
        return $this;
    }

    public function getHours_title() {
        return $this->_hoursTitle;
    }

    public function setMap_title($title) {
        $this->_mapTitle = $title;
        return $this;
    }

    public function getMap_title() {
        return $this->_mapTitle;
    }

    public function setName_label($label) {
        $this->_nameLabel = $label;
        return $this;
    }

    public function getName_label() {
        return $this->_nameLabel;
    }

    public function setEmail_label($label) {
        $this->_emailLabel = $label;
        return $this;
    }

    public function getEmail_label() {
        return $this->_emailLabel;
    }

    public function setPhone_label($label) {
        $this->_phoneLabel = $label;
        return $this;
    }

    public function getPhone_label() {
        return $this->_phoneLabel;
    }

    public function setExtra_label($label) {
        $this->_extraLabel = $label;
        return $this;
    }

    public function getExtra_label() {
        return $this->_extraLabel;
    }

    public function setMessage_label($label) {
        $this->_messageLabel = $label;
        return $this;
    }

    public function getMessage_label() {
        return $this->_messageLabel;
    }

    public function setAppointment_text($text) {
        $this->_appointmentText = $text;
        return $this;
    }

    public function getAppointment_text() {
        return $this->_appointmentText;
    }

    public function setSend_mail($text) {
        $this->_sendMail = $text;
        return $this;
    }

    public function getSend_mail() {
        return $this->_sendMail;
    }

    public function setMon_from($time) {
        $this->_monFrom = $time;
        return $this;
    }

    public function getMon_from() {
        return $this->_monFrom;
    }

    public function setTue_from($time) {
        $this->_tueFrom = $time;
        return $this;
    }

    public function getTue_from() {
        return $this->_tueFrom;
    }

    public function setWed_from($time) {
        $this->_wedFrom = $time;
        return $this;
    }

    public function getWed_from() {
        return $this->_wedFrom;
    }

    public function setThu_from($time) {
        $this->_thuFrom = $time;
        return $this;
    }

    public function getThu_from() {
        return $this->_thuFrom;
    }

    public function setFri_from($time) {
        $this->_friFrom = $time;
        return $this;
    }

    public function getFri_from() {
        return $this->_friFrom;
    }

    public function setSat_from($time) {
        $this->_satFrom = $time;
        return $this;
    }

    public function getSat_from() {
        return $this->_satFrom;
    }

    public function setSun_from($time) {
        $this->_sunFrom = $time;
        return $this;
    }

    public function getSun_from() {
        return $this->_sunFrom;
    }

    public function setMap_description($description) {
        $this->_mapDescription = $description;
        return $this;
    }

    public function getMap_description() {
        return $this->_mapDescription;
    }

    public function setMap_object($_mapObject){
        $this->_mapObject = $_mapObject;
        return $this;
    }

    public function getMap_object(){
        return $this->_mapObject;
    }

    public function setAddress($address){
        $this->_address = $address;
        return $this;
    }

    public function getAddress(){
        return $this->_address;
    }
}