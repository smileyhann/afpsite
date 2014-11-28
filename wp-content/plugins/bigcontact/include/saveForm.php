<?php

if (isset($_POST['id'])) {
    define('WP_USE_THEMES', false);
    require_once('../../../../wp-load.php');
    require_once('../models/form.php');
    require_once('../models/email.php');
    require_once('../models/phone.php');
    require_once('../models/formMapper.php');
    require_once('../models/emailMapper.php');
    require_once('../models/phoneMapper.php');

    global $wpdb;
    $value =  isset($_POST['value'])?strip_tags(htmlspecialchars(stripslashes(trim($_POST['value'])), ENT_QUOTES,'UTF-8')):'';
    $id = isset($_POST['id'])? trim(strip_tags($_POST['id'])) :'';

    if ($id == 'add_new_phone') {
        $options = array('label' => 'Phone', 'number' => '###-###-####');
        $phone = new BigContact_Models_Phone($options);
        $phone_mapper = new BigContact_Models_PhoneMapper();
        if (!$phone_mapper->save($phone))
            $value = json_encode(array('state' => 'error', 'message' => 'Something Went Wrong'));
        else
            $value = json_encode(array('state' => 'success', 'message' => $wpdb->insert_id));
    } elseif ($id == 'add_new_email') {
        $options = array('label' => 'Email', 'address' => 'example@domain.com');
        $email = new BigContact_Models_Email($options);
        $emailMapper = new BigContact_Models_EmailMapper();
        if (!$emailMapper->save($email))
            $value = json_encode(array('state' => 'error', 'message' => 'Something Went Wrong'));
        else
            $value = json_encode(array('state' => 'success', 'message' => $wpdb->insert_id));
    } elseif ($id == 'remove_phone') {
        $phone_mapper = new BigContact_Models_PhoneMapper();
        if (!$phone_mapper->remove($value))
            $value = json_encode(array('state' => 'error', 'message' => 'Something Went Wrong'));
        else
            $value = json_encode(array('state' => 'success'));
    } elseif ($id == 'remove_email') {
        $emailMapper = new BigContact_Models_EmailMapper();
        if (!$emailMapper->remove($value))
            $value = json_encode(array('state' => 'error', 'message' => 'Something Went Wrong'));
        else
            $value = json_encode(array('state' => 'success'));
    } elseif ($id == 'p_label') {
        $parent_id = isset($_POST['parent_id'])?trim(strip_tags($_POST['parent_id'])):'';
        $phoneMapper = new BigContact_Models_PhoneMapper();
        $phone = $phoneMapper->find($parent_id, new BigContact_Models_Phone());
        $phone->setLabel($value);
        $phoneMapper->save($phone);

    } elseif ($id == 'phone_number') {
        $parent_id = isset($_POST['parent_id'])?trim(strip_tags($_POST['parent_id'])):'';
        $phoneMapper = new BigContact_Models_PhoneMapper();
        $phone = $phoneMapper->find($parent_id, new BigContact_Models_Phone());
        $phone->setNumber($value);
        $phoneMapper->save($phone);

    } elseif ($id == 'e_label') {
        $parent_id = isset($_POST['parent_id'])?trim(strip_tags($_POST['parent_id'])):'';
        $emailMapper = new BigContact_Models_EmailMapper();
        $email = $emailMapper->find($parent_id, new BigContact_Models_Email());
        $email->setLabel($value);
        $emailMapper->save($email);

    } elseif ($id == 'email_address') {
        $parent_id = isset($_POST['parent_id'])?trim(strip_tags($_POST['parent_id'])):'';
        $emailMapper = new BigContact_Models_EmailMapper();
        $email = $emailMapper->find($parent_id, new BigContact_Models_Email());
        $email->setAddress($value);
        $emailMapper->save($email);

    } else {
        $columns = array();
        $formMapper = new BigContact_Models_FormMapper();
        $forms = $formMapper->fetchAll();
        if (!$form = $forms[0])
            $form = new BigContact_Models_Form();
        $columnData = $wpdb->get_results('SHOW COLUMNS FROM ' . $formMapper->getDbTable());
        foreach ($columnData as $column)
            $columns[] = $column->Field;
        if (in_array($id, $columns)) {
            $form->__set($id, $value);
            $formMapper->save($form);
        }
    }
}
