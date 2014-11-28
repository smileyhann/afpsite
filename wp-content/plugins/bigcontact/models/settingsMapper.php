<?php

/**
 * Description of settingsMapper
 *
 * @author Arian Khosravi <arian@bigemployee.com>, <@ArianKhosravi>
 */
class BigContact_Models_SettingsMapper {

    protected $_dbTable;

    public function setDbTable($dbTable) {
        global $wpdb;
        $this->_dbTable = $wpdb->prefix . $dbTable;
        return $this;
    }

    public function getDbTable() {
        if (null === $this->_dbTable) {
            $this->setDbTable('big_contacts_settings');
        }
        return $this->_dbTable;
    }

    public function save(BigContact_Models_Settings $bigSettings) {
        global $wpdb;
        $data = array(
            'bcc' => $bigSettings->getBcc(),
            'emailTo' => $bigSettings->getEmailTo(),
            'appointTo' => $bigSettings->getAppointTo(),
            'emailSubject' => $bigSettings->getEmailSubject(),
            'emailMessage' => $bigSettings->getEmailMessage(),
            'appointSubject' => $bigSettings->getAppointSubject(),
            'appointMessage' => $bigSettings->getAppointMessage(),
            'response' => $bigSettings->getResponse(),
            'replyEmail' => $bigSettings->getReplyEmail(),
            'replySubject' => $bigSettings->getReplySubject(),
            'replyMessage' => $bigSettings->getReplyMessage(),
            'gapiKey' => $bigSettings->getGapiKey(),
            'jQueryUiPath' => $bigSettings->getJQueryUiPath(),
            'calendarType' => $bigSettings->getCalendarType(),
            'dateFormat' => $bigSettings->getDateFormat(),
            'timeFormat' => $bigSettings->getTimeFormat(),
            'ampm' => $bigSettings->getAmpm(),
            'showMinute' => $bigSettings->getShowMinute(),
            'locale' => $bigSettings->getLocale(),
            'trackingCallback' => $bigSettings->getTrackingCallback(),
            'tracking' => $bigSettings->getTracking(),
        );
        if (null === ($id = $bigSettings->getId())) {
            unset($data['id']);
            return $wpdb->insert($this->getDbTable(), $data);
        } else {
            return $wpdb->update($this->getDbTable(), $data, array('id' => $bigSettings->getId()));
        }
    }

    public function find($id, BigContact_Models_Settings $bigSettings) {
        global $wpdb;
        $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$this->getDbTable()}` WHERE id = %d", $id));
        if (count($row)) {
            $bigSettings->setId($row->id)
                    ->setBcc($row->bcc)
                    ->setEmail_to($row->emailTo)
                    ->setAppointTo($row->appointTo)
                    ->setEmailSubject($row->emailSubject)
                    ->setEmailMessage($row->emailMessage)
                    ->setAppointSubject($row->appointSubject)
                    ->setAppointMessage($row->appointMessage)
                    ->setResponse($row->response)
                    ->setReplyEmail($row->replyEmail)
                    ->setReplySubject($row->replySubject)
                    ->setReplyMessage($row->replyMessage)
                    ->setGapiKey($row->gapiKey)
                    ->setJQueryUiPath($row->jQueryUiPath)
                    ->setCalendarType($row->calendarType)
                    ->setDateFormat($row->dateFormat)
                    ->setTimeFormat($row->timeFormat)
                    ->setAmpm($row->ampm)
                    ->setShowMinute($row->showMinute)
                    ->setLocale($row->locale)
                    ->setTrackingCallback($row->trackingCallback)
                    ->setTracking($row->tracking);
            return $bigSettings;
        }

        return;
    }

    public function fetchAll() {
        global $wpdb;
        $resultSet = $wpdb->get_results("SELECT * FROM `{$this->getDbTable()}`");
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new BigContact_Models_Settings();
            $entry->setId($row->id)
                    ->setBcc($row->bcc)
                    ->setEmail_to($row->emailTo)
                    ->setAppointTo($row->appointTo)
                    ->setEmailSubject($row->emailSubject)
                    ->setEmailMessage($row->emailMessage)
                    ->setAppointSubject($row->appointSubject)
                    ->setAppointMessage($row->appointMessage)
                    ->setResponse($row->response)
                    ->setReplyEmail($row->replyEmail)
                    ->setReplySubject($row->replySubject)
                    ->setReplyMessage($row->replyMessage)
                    ->setGapiKey($row->gapiKey)
                    ->setJQueryUiPath($row->jQueryUiPath)
                    ->setCalendarType($row->calendarType)
                    ->setDateFormat($row->dateFormat)
                    ->setTimeFormat($row->timeFormat)
                    ->setAmpm($row->ampm)
                    ->setShowMinute($row->showMinute)
                    ->setLocale($row->locale)
                    ->setTrackingCallback($row->trackingCallback)
                    ->setTracking($row->tracking);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function remove($id) {
        global $wpdb;
        return $wpdb->query($wpdb->prepare("DELETE FROM `{$this->getDbTable()}` WHERE id = %d", $id));
    }

}