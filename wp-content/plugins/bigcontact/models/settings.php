<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of settings
 *
 * @author Arian Khosravi <arian@bigemployee.com>, <@ArianKhosravi>
 */
class BigContact_Models_Settings {

    protected $_id;
    protected $_bcc;
    protected $_emailTo;
    protected $_appointTo;
    protected $_emailSubject;
    protected $_emailMessage;
    protected $_appointSubject;
    protected $_appointMessage;
    protected $_response;
    protected $_replyEmail;
    protected $_replySubject;
    protected $_replyMessage;
    protected $_gapiKey;
    protected $_jQueryUiPath;
    protected $_calendarType;
    protected $_dateFormat;
    protected $_timeFormat;
    protected $_ampm;
    protected $_showMinute;
    protected $_locale;
    protected $_trackingCallback;
    protected $_tracking;

    public function __construct(array $options = NULL) {
        if (is_array($options))
            $this->setOptions($options);
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if ('mapper' == $name && !method_exists($this, $method))
            return new Exception('Invalid bigcontact settings function');
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name();
        if ('mapper' == $name && !method_exists($this, $method))
            return new Exception('Invalid bigcontact settings function');
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

    public function getBcc() {
        return $this->_bcc;
    }

    public function setBcc($_bcc) {
        $this->_bcc = $_bcc;
        return $this;
    }

    public function getId() {
        return $this->_id;
    }

    public function setId($_id) {
        $this->_id = $_id;
        return $this;
    }

    public function getEmailTo() {
        return $this->_emailTo;
    }

    public function setEmail_to($_emailTo) {
        $this->_emailTo = $_emailTo;
        return $this;
    }

    public function getAppointTo() {
        return $this->_appointTo;
    }

    public function setAppointTo($_appointTo) {
        $this->_appointTo = $_appointTo;
        return $this;
    }

    public function getEmailSubject() {
        return $this->_emailSubject;
    }

    public function setEmailSubject($_emailSubject) {
        $this->_emailSubject = $_emailSubject;
        return $this;
    }

    public function getEmailMessage() {
        return $this->_emailMessage;
    }

    public function setEmailMessage($_emailMessage) {
        $this->_emailMessage = $_emailMessage;
        return $this;
    }

    public function getAppointSubject() {
        return $this->_appointSubject;
    }

    public function setAppointSubject($_appointSubject) {
        $this->_appointSubject = $_appointSubject;
        return $this;
    }

    public function getAppointMessage() {
        return $this->_appointMessage;
    }

    public function setAppointMessage($_appointMessage) {
        $this->_appointMessage = $_appointMessage;
        return $this;
    }

    public function getResponse() {
        return $this->_response;
    }

    public function setResponse($_response) {
        $this->_response = $_response;
        return $this;
    }

    public function getReplyEmail() {
        return $this->_replyEmail;
    }

    public function setReplyEmail($_replyEmail) {
        $this->_replyEmail = $_replyEmail;
        return $this;
    }

    public function getReplySubject() {
        return $this->_replySubject;
    }

    public function setReplySubject($_replySubject) {
        $this->_replySubject = $_replySubject;
        return $this;
    }

    public function getReplyMessage() {
        return $this->_replyMessage;
    }

    public function setReplyMessage($_replyMessage) {
        $this->_replyMessage = $_replyMessage;
        return $this;
    }

    public function getGapiKey() {
        return $this->_gapiKey;
    }

    public function setGapiKey($_gapiKey) {
        $this->_gapiKey = $_gapiKey;
        return $this;
    }

    public function getJQueryUiPath() {
        return $this->_jQueryUiPath;
    }

    public function setJQueryUiPath($_jQueryUiPath) {
        $this->_jQueryUiPath = $_jQueryUiPath;
        return $this;
    }

    public function getCalendarType() {
        return $this->_calendarType;
    }

    public function setCalendarType($_type) {
        $this->_calendarType = $_type;
        return $this;
    }

    public function getDateFormat() {
        return $this->_dateFormat;
    }

    public function setDateFormat($_dateFormat) {
        $this->_dateFormat = $_dateFormat;
        return $this;
    }

    public function getTimeFormat() {
        return $this->_timeFormat;
    }

    public function setTimeFormat($_timeFormat) {
        $this->_timeFormat = $_timeFormat;
        return $this;
    }

    public function getAmpm() {
        return $this->_ampm;
    }

    public function setAmpm($_ampm) {
        $this->_ampm = $_ampm;
        return $this;
    }

    public function getShowMinute() {
        return $this->_showMinute;
    }

    public function setShowMinute($_showMinute) {
        $this->_showMinute = $_showMinute;
        return $this;
    }

    public function getLocale() {
        return $this->_locale;
    }

    public function setLocale($_locale) {
        $this->_locale = $_locale;
        return $this;
    }

//        protected $_trackingCallback;
//    protected $_tracking;

    public function getTrackingCallback() {
        return $this->_trackingCallback;
    }

    public function setTrackingCallback($_trackingCallback) {
        $this->_trackingCallback = $_trackingCallback;
        return $this;
    }

    public function getTracking() {
        return $this->_tracking;
    }

    public function setTracking($_tracking) {
        $this->_tracking = $_tracking;
        return $this;
    }

}
