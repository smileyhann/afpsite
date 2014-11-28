<?php

/**
 * Description of formMapper
 *
 * @author Arian Khosravi <arian@bigemployee.com>, <@ArianKhosravi>
 */
class BigContact_Models_FormMapper {

    protected $_dbTable;

    public function setDbTable($dbTable) {
        global $wpdb;
        $this->_dbTable = $wpdb->prefix . $dbTable;
        return $this;
    }

    public function getDbTable() {
        if (null === $this->_dbTable) {
            $this->setDbTable('big_contacts');
        }
        return $this->_dbTable;
    }

    public function save(BigContact_Models_Form $bigForm) {
        global $wpdb;
        $data = array(
            'form_title' => $bigForm->getForm_title(),
            'tel_title' => $bigForm->getTel_title(),
            'email_title' => $bigForm->getEmail_title(),
            'hours_title' => $bigForm->getHours_title(),
            'map_title' => $bigForm->getMap_title(),
            'name_label' => $bigForm->getName_label(),
            'email_label' => $bigForm->getEmail_label(),
            'phone_label' => $bigForm->getPhone_label(),
            'extra_label' => $bigForm->getExtra_label(),
            'message_label' => $bigForm->getMessage_label(),
            'appointment_text' => $bigForm->getAppointment_text(),
            'send_mail' => $bigForm->getSend_mail(),
            'mon_from' => $bigForm->getMon_from(),
            'tue_from' => $bigForm->getTue_from(),
            'wed_from' => $bigForm->getWed_from(),
            'thu_from' => $bigForm->getThu_from(),
            'fri_from' => $bigForm->getFri_from(),
            'sat_from' => $bigForm->getSat_from(),
            'sun_from' => $bigForm->getSun_from(),
            'map_description' => $bigForm->getMap_description(),
            'map_object' => $bigForm->getMap_object(),
            'address' => $bigForm->getAddress()
        );
        if (null === ($id = $bigForm->getId())) {
            unset($data['id']);
            return $wpdb->insert($this->getDbTable(), $data);
        } else {
            return $wpdb->update($this->getDbTable(), $data, array('id' => $bigForm->getId()));
        }
    }

    public function find($id, BigContact_Models_Form $bigForm) {
        global $wpdb;
        $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$this->getDbTable()}` WHERE id = %d",$id));
        if (count($row)) {
            $bigForm->setId($row->id)
                    ->setForm_title($row->form_title)
                    ->setTel_title($row->tel_title)
                    ->setEmail_title($row->email_title)
                    ->setHours_title($row->hours_title)
                    ->setMap_title($row->map_title)
                    ->setName_label($row->name_label)
                    ->setEmail_label($row->email_label)
                    ->setPhone_label($row->phone_label)
                    ->setExtra_label($row->extra_label)
                    ->setMessage_label($row->message_label)
                    ->setAppointment_text($row->appointment_text)
                    ->setSend_mail($row->send_mail)
                    ->setMon_from($row->mon_from)
                    ->setTue_from($row->tue_from)
                    ->setWed_from($row->wed_from)
                    ->setThu_from($row->thu_from)
                    ->setFri_from($row->fri_from)
                    ->setSat_from($row->sat_from)
                    ->setSun_from($row->sun_from)
                    ->setMap_description($row->map_description)
                    ->setMap_object($row->map_object)
                    ->setAddress($row->address);
            return $bigForm;
        }

        return;
    }

    public function fetchAll() {
        global $wpdb;
        $resultSet = $wpdb->get_results("SELECT * FROM `{$this->getDbTable()}`");
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new BigContact_Models_Form();
            $entry->setId($row->id)
                    ->setForm_title($row->form_title)
                    ->setTel_title($row->tel_title)
                    ->setEmail_title($row->email_title)
                    ->setHours_title($row->hours_title)
                    ->setMap_title($row->map_title)
                    ->setName_label($row->name_label)
                    ->setEmail_label($row->email_label)
                    ->setPhone_label($row->phone_label)
                    ->setExtra_label($row->extra_label)
                    ->setMessage_label($row->message_label)
                    ->setAppointment_text($row->appointment_text)
                    ->setSend_mail($row->send_mail)
                    ->setMon_from($row->mon_from)
                    ->setTue_from($row->tue_from)
                    ->setWed_from($row->wed_from)
                    ->setThu_from($row->thu_from)
                    ->setFri_from($row->fri_from)
                    ->setSat_from($row->sat_from)
                    ->setSun_from($row->sun_from)
                    ->setMap_description($row->map_description)
                    ->setMap_object($row->map_object)
                    ->setAddress($row->address);
            $entries[] = $entry;
        }
        return $entries;
    }

}