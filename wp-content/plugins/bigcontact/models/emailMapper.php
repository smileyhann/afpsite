<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of emailMapper
 *
 * @author Arian Khosravi <arian@bigemployee.com>, <@ArianKhosravi>
 */
class BigContact_Models_EmailMapper {

    protected $_dbTable;

    public function setDbTable($dbTable) {
        global $wpdb;
        $this->_dbTable = $wpdb->prefix . $dbTable;
        return $this;
    }

    public function getDbTable() {
        if (null === $this->_dbTable) {
            $this->setDbTable('big_contacts_emails');
        }
        return $this->_dbTable;
    }

    public function save(BigContact_Models_Email $bigEmail) {
        global $wpdb;
        $data = array(
            'label' => $bigEmail->getLabel(),
            'address' => $bigEmail->getAddress()
        );
        if (null === ($id = $bigEmail->getId())) {
            unset($data['id']);
            return $wpdb->insert($this->getDbTable(), $data);
        } else {
            return $wpdb->update($this->getDbTable(), $data, array('id' => $bigEmail->getId()));
        }
    }

    public function find($id, BigContact_Models_Email $bigEmail) {
        global $wpdb;
        $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$this->getDbTable()}` WHERE id = %d", $id));
        if (count($row)) {
            $bigEmail->setId($row->id)
                    ->setLabel($row->label)
                    ->setAddress($row->address);
            return $bigEmail;
        }

        return;
    }

    public function fetchAll() {
        global $wpdb;
        $resultSet = $wpdb->get_results("SELECT * FROM `{$this->getDbTable()}`");
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new BigContact_Models_Email();
            $entry->setId($row->id)
                    ->setLabel($row->label)
                    ->setAddress($row->address);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function remove($id) {
        global $wpdb;
        return $wpdb->query($wpdb->prepare("DELETE FROM `{$this->getDbTable()}` WHERE id = %d", $id));
    }

}