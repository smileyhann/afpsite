<?php

/**
 * Description of phoneMapper
 *
 * @author Arian Khosravi <arian@bigemployee.com>, <@ArianKhosravi>
 */
class BigContact_Models_PhoneMapper {

    protected $_dbTable;

    public function setDbTable($dbTable) {
        global $wpdb;
        $this->_dbTable = $wpdb->prefix . $dbTable;
        return $this;
    }

    public function getDbTable() {
        if (null === $this->_dbTable) {
            $this->setDbTable('big_contacts_phones');
        }
        return $this->_dbTable;
    }

    public function save(BigContact_Models_Phone $bigPhone) {
        global $wpdb;
        $data = array(
            'label' => $bigPhone->getLabel(),
            'number' => $bigPhone->getNumber()
        );
        if (null === ($id = $bigPhone->getId())) {
            unset($data['id']);
            return $wpdb->insert($this->getDbTable(), $data);
        } else {
            return $wpdb->update($this->getDbTable(), $data, array('id' => $bigPhone->getId()));
        }
    }

    public function find($id, BigContact_Models_Phone $bigPhone) {
        global $wpdb;
        $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$this->getDbTable()}` WHERE id = %d", $id));
        if (count($row)) {
            $bigPhone->setId($row->id)
                    ->setLabel($row->label)
                    ->setNumber($row->number);
            return $bigPhone;
        }

        return;
    }

    public function fetchAll() {
        global $wpdb;
        $resultSet = $wpdb->get_results("SELECT * FROM `{$this->getDbTable()}`");
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new BigContact_Models_Phone();
            $entry->setId($row->id)
                    ->setLabel($row->label)
                    ->setNumber($row->number);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function remove($id) {
        global $wpdb;
        return $wpdb->query($wpdb->prepare("DELETE FROM `{$this->getDbTable()}` WHERE id = %d", $id));
    }

}